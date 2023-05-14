<style>

</style>
<div id="password-confirmation-modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> -->
                <h4 class="modal-title">Lock/Unlock Action Authorization</h4>
            </div>
            <div class="modal-body">

                   <form class="form-horizontal" role="form">
                     <div class="form-group">
                       <label class="col-sm-2 control-label"
                             for="inputPassword3" >Password</label>
                       <div class="col-sm-10">
                           <input type="password" class="form-control"
                               id="password-authorize" placeholder="Password"/>
                       </div>
                     </div>
                     <div class="col-md-8 col-md-offset-2" id="msg-password-authorize"></div>
                   </form>
               </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default modal-close" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-password-authorization">Submit</button>
            </div>
        </div>

    </div>
</div>
