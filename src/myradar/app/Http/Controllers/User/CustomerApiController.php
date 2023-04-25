<?php

namespace App\Http\Controllers\User;

use App\Entities\User;
use App\Http\Requests\CreateCustomer;
use Illuminate\Http\Request;

use App\Http\Requests\CreateUser;
use App\Http\Controllers\Controller;
use App\Criteria\CustomerNameCriteria;
use Illuminate\Support\Facades\Hash;
use App\Contract\Repositories\UserRepository;
use App\Criteria\ModelTypeCriteria;
use App\Criteria\UserRegNoCriteria;
use App\Criteria\UserRefNoCriteria;
use App\Criteria\WithTrashedCriteria;
use App\Criteria\FullNameCriteria;
use App\Criteria\PhoneNumberCriteria;
use App\Presenters\CustomerPresenter;
use App\Http\Controllers\Sms\SMSController;
use Mail;
use App\Presenters\CustomerInfoPresenter;


class CustomerApiController extends Controller
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->middleware('auth');
        $this->repository = $repository;
         $this->SMS = new SMSController();
         $this->User = new User();
    }

    public function index(Request $request)
    {
        $this->repository->setPresenter(CustomerPresenter::class);

        $this->repository->pushCriteria(new WithTrashedCriteria());
        $this->repository->pushCriteria(new ModelTypeCriteria(User::$TYPE_CUSTOMER));

        if (strlen($name = $request->input('name', ''))) {
            $this->repository->pushCriteria(new FullNameCriteria($name));
        }

        if (strlen($phone = $request->input('phone', ''))) {
            $this->repository->pushCriteria(new PhoneNumberCriteria($phone));
        }

        if (strlen($reg_no = $request->input('reg_no', ''))) {
            $this->repository->pushCriteria(new UserRegNoCriteria($reg_no));
        }

        if (strlen($ref_no = $request->input('ref_no', ''))) {
            $this->repository->pushCriteria(new UserRefNoCriteria($ref_no));
        }

        return response()->json($this->repository->paginate());
      }

    public function types(Request $request)
    {
        return response()->json([
            ['id' => User::$CUSTOMER_PRIVATE, 'name' => 'Private Customer'],
            ['id' => User::$CUSTOMER_ENTERPRISE, 'name' => 'Enterprise Customer'],
            ['id' => User::$CUSTOMER_PUBLIC, 'name' => 'Public Customer'],
        ]);
    }

    public function add(CreateUser $request)
    {

        $user = User::create([
            'name' => $request->get('name'),
            'phone' => $request->get('phone'),
            'nid' => $request->get('nid'),
            'email' => $request->get('email'),
            'password' => bcrypt($random_password),
            'type' => User::$TYPE_CUSTOMER,
            'customer_type' => $request->get('type'),
            'note' => $request->get('note'),
        ]);

        if ( ! is_null($user)) {
          return response()->json([
                'msg'=>'Customer saved',
                'user_id'=>$user['_id']
              ]);
        }
          return response()->json([
                'msg'=>'Customer save failed'
              ]);

    }


    public function sendCredential(Request $request)
    {
     $user_id = $request->get('user');
     $password = $this->User->generateVerificationCode();
     $User = User::find($user_id);
     $content = "Hi, $User->name ,Your Password is ".$password;
     $subject = "Account Created Successfully";
     //save pass

     $User->password = bcrypt($password);
     $User->save();

     if(!is_null($User->email) && !is_null($User->phone)) {
       //sms and mail both

       Mail::raw($content,function ($message) use($User,$subject) {
         $message->to($User->email)
           ->subject($subject);
       });
      $sendSMS =  $this->SMS->sendSMS($User->phone,$content);
     }

     if(!is_null($User->email)&& is_null($User->phone))
      {

       Mail::raw($content,function ($message) use($User,$subject) {
         $message->to($User->email)
           ->subject($subject);
       });

      }
      elseif(is_null($User->email)&& !is_null($User->phone)){
       //sms
        $sendSMS =  $this->SMS->sendSMS($User->phone,$content);

      }

    }

    public function delete(Request $request){
      if (User::destroy($request->get('id'))) {
        return response()->json([
              'msg'=>'Customer Deleted',
            ]);
      }

    }

    public function info(Request $request, $id)
    {
        $this->repository->setPresenter(CustomerInfoPresenter::class);
        return response()->ok($this->repository->find($id));
    }

}
