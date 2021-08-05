@extends('layouts.app')
@section('content')
@if(Auth::user()->role == 'Administrateur' or Auth::user()->role == 'Concepteur')
<script src="{{asset('js/crud.js')}}"></script>
<script src="{{asset('plugins/jQuery/jquery.validate.min.js')}}"></script>
<script src="{{asset('plugins/bootstrap-table/dist/bootstrap-table.min.js')}}"></script>
<script src="{{asset('plugins/bootstrap-table/dist/locale/bootstrap-table-fr-FR.min.js')}}"></script>
<script src="{{asset('plugins/js/underscore-min.js')}}"></script>
<script src="{{asset('template/js/pages/features/forms/widgets/input-mask.js')}}"></script>

<link href="{{asset('plugins/bootstrap-table/dist/bootstrap-table.min.css')}}" rel="stylesheet">
    
    <div class="row">    
        <div class="col-xl-12">
            <div class="card card-custom">
                <div class="card-header">
                    <h3 class="card-title">
                        Liste des utilisateurs
                    </h3>
                </div>
                <div class="card-body">
                    <div id="kt_datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="table" class="table table-bordered table-hover table-checkable dataTable no-footer dtr-inline"
                                       data-pagination="true"
                                       data-search="false"
                                       data-toggle="table"
                                       data-url="{{url('auth',['action'=>'liste-users'])}}"
                                       data-unique-id="id"
                                       data-show-toggle="false">
                                    <thead>
                                        <tr role="row">
                                            <th data-field="id" data-formatter="passwordResetFormatter" data-width="60px" data-align="center"><i class="la la-exclamation"></i></th>
                                            <th data-field="user_name" data-sortable="true" data-searchable="true">Nom</th>
                                            <th data-field="email" data-searchable="true">E-mail</th>
                                            <th data-field="contact" data-searchable="true">Contact</th>
                                            <th data-field="role" data-searchable="true">Role</th>
                                            <th data-field="statut_compte" data-formatter="etatCompteFormatter">Etat</th>
                                            <th data-field="last_login">Derni&egrave;re connexion</th>
                                            <th data-field="id" data-formatter="optionFormatter" data-width="100px" data-align="center"><i class="la la-wrench"></i></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
  <!-- Modal ajout-->
<div class="modal fade bs-modal-add" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-lg" style="width:70%">
        <form id="addForm" ng-controller="addFormCtrl" action="#">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Gestion des utilisateurs</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close text-white"></i>
                </button>
            </div>
            <input type="hidden" id="idUserToModify" value="@{{user.id}}" class="hidden" ng-hide="true"/>
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label>Nom complet *</label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="flaticon2-user icon-lg"></i>
                                    </span>
                                </div>
                                <input type="text" onkeyup="this.value = this.value.charAt(0).toUpperCase() + this.value.substr(1);" class="form-control" id="name" name="user_name" ng-model="user.user_name"  placeholder="Nom et pr&eacute;nom de l'utilisateur" required/>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label for="rule_id">Role *</label>
                            <select class="form-control" id="role" name="role" ng-model="user.role" ng-init="user.role='Administrateur'" required>
                                <option value="Administrateur"> Administrateur</option>
                                <option value="Superviseur"> Superviseur</option>
                            </select> 
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label>E-mail *</label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="flaticon-email icon-lg"></i>
                                    </span>
                                </div>
                                <input type="email" class="form-control" id="email" name="email" ng-model="user.email" placeholder="E-mail de l'utilisateur..." required/>
                            </div>
                        </div>
                    </div>
                       <div class="col-xl-6">
                        <div class="form-group">
                            <label>Contact *</label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="flaticon-support icon-lg"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" id="contact" name="contact" ng-model="user.contact" placeholder="Contact de l'utilisateur..." required/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary font-weight-bold spinner spinner-white spinner-right btn-add">Valider</button>
            </div>
        </div>
        </form>
    </div>
</div>  
    
    
<!--Modal loked acompt-->
<div class="modal fade bs-modal-lokked-acount" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="formLokedAcount" ng-controller="formLokedAcountCtrl" action="#">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white">Gestion du compte</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close text-white"></i>
                    </button>
                </div>
                <div class="modal-body">
                   <input type="text" id="idUserLokedAcount" ng-model="user.id" ng-hide="true" class="hidden"/>
                   @csrf
                       <div class="d-flex align-items-center p-5">
                           <div class="mr-4">
                               <span class="svg-icon svg-icon-danger svg-icon-3x">
                                   <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="40px" height="40px" viewBox="0 0 24 24" version="1.1">
                                   <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                   <rect x="0" y="0" width="50" height="50"/>
                                   <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"/>
                                   <path d="M12,16 C12.5522847,16 13,16.4477153 13,17 C13,17.5522847 12.5522847,18 12,18 C11.4477153,18 11,17.5522847 11,17 C11,16.4477153 11.4477153,16 12,16 Z M10.591,14.868 L10.591,13.209 L11.851,13.209 C13.447,13.209 14.602,11.991 14.602,10.395 C14.602,8.799 13.447,7.581 11.851,7.581 C10.234,7.581 9.121,8.799 9.121,10.395 L7.336,10.395 C7.336,7.875 9.31,5.922 11.851,5.922 C14.392,5.922 16.387,7.875 16.387,10.395 C16.387,12.915 14.392,14.868 11.851,14.868 L10.591,14.868 Z" fill="#000000"/>
                                   </g>
                                   </svg>
                               </span>
                           </div>
                           <div class="d-flex flex-column">
                               <div class="text-dark-75 text-center"> 
                                   <div class="spinner spinner-danger spinner-lg mr-15 interrogation">
                                        Etes vous certain de vouloir <b>@{{user.statut_compte === 1 ? " fermer " : " ouvrir"}}</b> ce compte ? <br/> <b>@{{user.user_name}}</b>
                                   </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-light font-weight-bold" data-dismiss="modal">Non</button>
                    <button type="submit" class="btn btn-sm btn-danger font-weight-bold">Oui</button>
                </div>
            </div>
        </form>
    </div>
</div>
   
<!--Password reset modal-->
<div class="modal fade bs-modal-password-reset" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="passwordResetForm" ng-controller="passwordResetFormCtrl" action="#">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-white">R&eacute;initialiser le mot de passe</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close text-white"></i>
                    </button>
                </div>
                <div class="modal-body">
                   <input type="text" name="userId" ng-model="user.id" ng-hide="true" class="hidden"/>
                   @csrf
                  
                       <div class="d-flex align-items-center p-5">
                           <div class="mr-4">
                               <span class="svg-icon svg-icon-warning svg-icon-3x">
                                   <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="40px" height="40px" viewBox="0 0 24 24" version="1.1">
                                   <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                   <rect x="0" y="0" width="50" height="50"/>
                                   <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"/>
                                   <path d="M12,16 C12.5522847,16 13,16.4477153 13,17 C13,17.5522847 12.5522847,18 12,18 C11.4477153,18 11,17.5522847 11,17 C11,16.4477153 11.4477153,16 12,16 Z M10.591,14.868 L10.591,13.209 L11.851,13.209 C13.447,13.209 14.602,11.991 14.602,10.395 C14.602,8.799 13.447,7.581 11.851,7.581 C10.234,7.581 9.121,8.799 9.121,10.395 L7.336,10.395 C7.336,7.875 9.31,5.922 11.851,5.922 C14.392,5.922 16.387,7.875 16.387,10.395 C16.387,12.915 14.392,14.868 11.851,14.868 L10.591,14.868 Z" fill="#000000"/>
                                   </g>
                                   </svg>
                               </span>
                           </div>
                           <div class="d-flex flex-column">
                               <div class="text-dark-75 text-center"> 
                                    <div class="spinner spinner-warning spinner-lg mr-15 interrogation-reset">
                                   Etes vous certains de vouloir r&eacute;initialiser le mot de passe de cet utilisateur ? <br/> <b>@{{user.user_name}}</b>
                               </div>
                           </div>
                       </div>
                   </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-light font-weight-bold" data-dismiss="modal">Non</button>
                    <button type="submit" class="btn btn-sm btn-warning font-weight-bold">Oui</button>
                </div>
            </div>
        </form>
    </div>
</div>
  
<script type="text/javascript">
     var add = true;
     var $table = jQuery("#table"), rows = [];
    
    smartApp.controller('addFormCtrl', function ($scope) {
        $scope.populateForm = function (user) {
            $scope.user = user;
        };
        $scope.initForm = function () {
            ajout = true;
            $scope.user = {};
        };
    });
    
    smartApp.controller('passwordResetFormCtrl', function ($scope) {
        $scope.populateForm = function (user) {
            $scope.user = user;
        };
        $scope.initForm = function () {
            $scope.user = {};
        };
    });
    
    smartApp.controller('formLokedAcountCtrl', function ($scope) {
        $scope.populateForm = function (user) {
            $scope.user = user;
        };
        $scope.initForm = function () {
            $scope.user = {};
        };
    });
    
    $(function () {
        $table.on('load-success.bs.table', function (e, data) {
            rows = data.rows; 
        });
        
        // phone number format
        $("#contact").inputmask("mask", {
            "mask": "99 99 99 99 99"
        });
        $("#addForm").submit(function (e) {
            e.preventDefault();
            var $valid = $("#addForm");
            if (!$valid) {
                $validator.focusInvalid();
                return false;
            }
            
            var $ajaxSpinner = $(".btn-add");
            
            if (add==true) {
                var methode = 'POST';
                var url = "{{route('auth.users.store')}}";
            }else{
                var id = $("#idUserToModify").val();
                var methode = 'PUT';
                var url = 'users/' + id;
             }
            editAction(methode, url, $(this), $(this).serialize(), $ajaxSpinner, $table, add);
        });
        
        $("#formLokedAcount").submit(function (e) {
            e.preventDefault();
            var id = $("#idUserLokedAcount").val();
            var formData = $(this).serialize();
            var $ajaxLoader = $(".interrogation");
            lokedAcountAction('users/' + id, formData, $ajaxLoader, $table);
        });
        
        $("#passwordResetForm").submit(function (e) {
            e.preventDefault();
            var url = "{{route('auth.user.password-reset-by-admin')}}";
            var $ajaxLoader = $(".interrogation-reset");
            passwordResetAction(url, $(this).serialize(), $ajaxLoader, $table);
        });
    });

    function updateRow(idUser) {
        add = false;
        var $scope = angular.element($("#addForm")).scope();
        var user =_.findWhere(rows, {id: idUser});
        $scope.$apply(function () {
            $scope.populateForm(user);
        });
        
        $(".bs-modal-add").modal("show");
    }
    
    function lokedAcountRow(idUser) {
        var $scope = angular.element($("#formLokedAcount")).scope();
        var user =_.findWhere(rows, {id: idUser});
        $scope.$apply(function () {
        $scope.populateForm(user);
        });
        $(".bs-modal-lokked-acount").modal("show");
    }
    
    function resetPasswordRow(idUser) {
          var $scope = angular.element($("#passwordResetForm")).scope();
          var user =_.findWhere(rows, {id: idUser});
           $scope.$apply(function () {
              $scope.populateForm(user);
          });
       $(".bs-modal-password-reset").modal("show");
    }
    
    function etatCompteFormatter(etat){
        return etat==1 ? "<span class='label label-success label-pill label-inline mr-2'>Active</span>":"<span class='label label-danger label-pill label-inline mr-2'>Ferm&eacute;</span>";
    }

    function optionFormatter(id, row) {
        return '<button class="btn btn-xs btn-primary btn-icon" data-toggle="tooltip" data-theme="dark" title="Modifier" onClick="javascript:updateRow(' + id + ');"><i class="la la-edit"></i></button>\n\
                <button class="btn btn-xs btn-danger btn-icon"  data-toggle="tooltip" data-theme="dark" title="Fermer le compte" onClick="javascript:lokedAcountRow(' + id + ');"><i class="la la-ban"></i></button>';
    }
    
    function passwordResetFormatter(id, row){
        return '<button class="btn btn-xs btn-warning btn-icon" data-toggle="tooltip" data-theme="dark" title="Password reset" onClick="javascript:resetPasswordRow(' + id + ');"><i class="la la-refresh"></i></button>';
    }

//Password reset action
function lokedAcountAction(url, formData, $ajaxLoader, $table) {
    jQuery.ajax({
        type: "DELETE",
        url: url,
        cache: false,
        data: formData,
        success: function (response) {
            if (response.code === 1) {
                $table.bootstrapTable('refresh');
                $(".bs-modal-lokked-acount").modal("hide");
               toastr.success(response.msg, "SMART ORDO); 
            }
            if (response.code === 0) {
                toastr.warning(response.msg, "SMART ORDO");
            }
            if (response.code === -1) {
                toastr.error(response.msg, "SMART ORDO");
            }
        },
        error: function (err) {
            var res = eval('('+err.responseText+')');
            toastr.error(res.message, "SMART ORDO");
            $ajaxLoader.removeClass('spinner');
        },
        beforeSend: function () {
            $ajaxLoader.addClass('spinner');
        },
        complete: function () {
            $ajaxLoader.removeClass('spinner');
        }
    });
}

//Password reset action
function passwordResetAction(url, formData, $ajaxLoader, $table) {
    jQuery.ajax({
        type: "POST",
        url: url,
        cache: false,
        data: formData,
        success: function (response) {
            if (response.code === 1) {
                $table.bootstrapTable('refresh');
                $(".bs-modal-password-reset").modal("hide");
               toastr.success(response.msg, "SMART ORDO"); 
            }
            if (response.code === 0) {
                toastr.warning(response.msg, "SMART ORDO");
            }
            if (response.code === -1) {
                toastr.error(response.msg, "SMART ORDO");
            }
        },
        error: function (err) {
            var res = eval('('+err.responseText+')');
            toastr.error(res.message, "SMART ORDO");
            $ajaxLoader.removeClass('spinner');
        },
        beforeSend: function () {
            $ajaxLoader.addClass('spinner');
        },
        complete: function () {
            $ajaxLoader.removeClass('spinner');
        }
    });
}
</script>
@endif
@endsection
