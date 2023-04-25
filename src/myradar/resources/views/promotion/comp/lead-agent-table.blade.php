<div class="tw-w-full tw-px-5 tw-py-8">
  <div class="tw-w-full tw-flex tw-flex-row tw-justify-between tw-items-center tw-py-8">
    <span class="tw-text-2xl tw-font-semibold">{{ $title }}</span>
  </div>

  <form action="/lead/assignment/save" method="POST" id="{{ $id }}">
    {{ csrf_field() }}
    <input type="hidden" name="type" value="{{ $id }}">
  </form>

  <table class="tw-w-full">
    <thead class="tw-border tw-border-solid tw-border-gray-200 tw-rounded-md tw-overflow-hidden">
      <tr>
        <th class="tw-bg-gray-200 tw-px-6 tw-py-3 tw-text-center tw-w-1/12">
          <span class="tw-text-xl tw-font-semibold tw-text-gray-700">Serial</span>
        </th>
        <th class="tw-bg-gray-200 tw-px-6 tw-py-3 tw-text-center tw-w-4/12">
          <span class="tw-text-xl tw-font-semibold tw-text-gray-700">Agent Name</span>
        </th>
        <th class="tw-bg-gray-200 tw-px-6 tw-py-3 tw-text-center tw-w-4/12">
          <span class="tw-text-xl tw-font-semibold tw-text-gray-700">Phone Number</span>
        </th>
        <th class="tw-bg-gray-200 tw-px-6 tw-py-3 tw-text-center tw-w-3/12">
          <span class="tw-text-xl tw-font-semibold tw-text-gray-700">Action</span>
        </th>
      </tr>
    </thead>
    <tbody>
      @foreach ($agents as $i => $agent)
      <tr class="tw-py-3">
        <td class="tw-border-t tw-border-solid tw-border-gray-100 tw-text-center">
          {{ $i + 1 }}
        </td>
        <td class="tw-border-t tw-border-solid tw-border-gray-100 tw-py-3 tw-text-center">
          {{ $agent['name'] }}
        </td>
        <td class="tw-border-t tw-border-solid tw-border-gray-100 tw-py-3 tw-text-center">
          {{ $agent['phone'] }}
        </td>
        <td class="tw-border-t tw-border-solid tw-border-gray-100">
          <form action="/lead/assignment/remove" method="POST" class="tw-flex tw-flex-row tw-justify-center">
            <input type="hidden" name="id" value="{{ $agent['_id'] }}">
            <button
              class="tw-rounded-md tw-border tw-border-solid tw-border-red-300 tw-text-red-500 tw-text-xl tw-bg-white tw-py-2 tw-px-6 tw rounded-md">
              Delete
            </button>
            {{ csrf_field() }}
          </form>
        </td>
      </tr>
      @endforeach
      <tr>
        <td class="tw-text-center">
          <span><i class="fa fa-plus"></i></span>
        </td>
        <td>
          <select name="name" class="form-control tw-w-3/4" form="{{ $id }}">
            <option value="">Select Agent</option>
            <option value="Masud">Masud</option>
            <option value="Hasib">Hasib</option>
            <option value="Wahida">Wahida</option>
            <option value="Ahnaf">Ahnaf</option>
            <option value="Shahadat">Shahadat</option>
            <option value="Rubel">Rubel</option>
            <option value="Agent 1">Agent 1</option>
            <option value="Agent 2">Agent 2</option>
          </select>
        </td>
        <td class="tw-py-2 tw-px-8">
          <input type="text" class="form-control tw-w-3/4" name="phone" placeholder="Type here" form="{{ $id }}">
        </td>
        <td class="tw-py-2 tw-px-8">
          <div class="tw-flex tw-flex-row tw-justify-center">
            <button type="submit" form="{{ $id }}"
              class="tw-border-none tw-px-8 tw-py-3 tw-text-white tw-text-lg tw-font-medium tw-bg-green-500 hover:tw-bg-green-600 tw-transition tw-duration-300 tw-rounded-md">
              Add Agent
            </button>
          </div>
        </td>
      </tr>
    </tbody>
  </table>
</div>