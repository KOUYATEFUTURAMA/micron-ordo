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
                        Liste des pharmacies
                    </h3>
                </div>
                <div class="card-body">
                    <div id="kt_datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="table" class="table table-bordered table-hover table-checkable dataTable no-footer dtr-inline"
                                       data-pagination="true"
                                       data-search="true"
                                       data-toggle="table"
                                       data-url="{{url('parametre',['action'=>'liste-pharmacies'])}}"
                                       data-unique-id="id"
                                       data-show-toggle="false"
                                       data-show-columns="true">
                                    <thead>
                                        <tr role="row">
                                            <th data-field="nom_pharmacie" data-sortable="true" data-searchable="true">Pharmacie</th>
                                            <th data-field="contact_pharmacie">Contact</th>
                                            <th data-field="localite.libelle_localite">Localit&eacute;</th>
                                            <th data-field="adresse_pharmacie" data-searchable="true">Adresse</th>
                                            <th data-field="responsable" data-searchable="true">Responsable</th>
                                            <th data-field="logo" data-formatter="logoFormatter">Logo</th>
                                            <th data-field="contact_responsable" data-visible="false">Contact responsable</th>
                                            <th data-field="email" data-visible="false">E-mail</th>
                                           <th data-field="contact2" data-visible="false">Contact 2</th>
                                            <th data-field="faxe" data-visible="false">Faxe</th>
                                            <th data-field="boite_postale" data-visible="false">Boite postale</th>
                                            <th data-field="longitude" data-visible="false">Longitude</th>
                                            <th data-field="latitude" data-visible="false">Latitude</th>
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
        <form id="addForm" ng-controller="addFormCtrl" enctype="multipart/form-data" action="#">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Gestion des pharmacies</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close text-white"></i>
                </button>
            </div>
            <input type="hidden" name="idPharmacie" value="@{{pharmacie.id}}" class="hidden" ng-hide="true"/>
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label for="nom_pharmacie">Nom de la pharmacie *</label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="flaticon2-layers-1 icon-lg"></i>
                                    </span>
                                </div>
                                <input type="text" onkeyup="this.value = this.value.charAt(0).toUpperCase() + this.value.substr(1);" class="form-control" id="nom_pharmacie" name="nom_pharmacie" ng-model="pharmacie.nom_pharmacie"  placeholder="Nom de la pharmacie" required/>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label for="localite_id">Localit&eacute; *</label>
                            <div class="input-group input-group-sm">
                                <select class="form-control" id="localite_id" name="localite_id" required>
                                    <option value=""> Selectionner une localit&eacute;</option>
                                    @foreach($localites as $localite)
                                        <option value="{{$localite->id}}"> {{$localite->libelle_localite}}</option>
                                    @endforeach
                                </select> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-4">
                        <div class="form-group">
                            <label>Contact *</label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="flaticon-support icon-lg"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" id="contact_pharmacie" name="contact_pharmacie" ng-model="pharmacie.contact_pharmacie" placeholder="Contact de la pharmacie..." required/>
                            </div>
                        </div>
                    </div>
                     <div class="col-xl-8">
                        <div class="form-group">
                            <label for="nom_pharmacie">Adresse complete de la pharmacie *</label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="flaticon-pin icon-lg"></i>
                                    </span>
                                </div>
                                <input type="text" onkeyup="this.value = this.value.charAt(0).toUpperCase() + this.value.substr(1);" class="form-control" id="adresse_pharmacie" name="adresse_pharmacie" ng-model="pharmacie.adresse_pharmacie"  placeholder="Adresse de localisation" required/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label for="contact2">Contact 2 </label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="flaticon-support icon-lg"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" id="contact2" name="contact2" ng-model="pharmacie.contact2" placeholder="Contact 2 de la pharmacie..."/>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label>Faxe </label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="flaticon2-fax icon-lg"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" id="faxe" name="faxe" ng-model="pharmacie.faxe" placeholder="Faxe de la pharmacie..."/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                   <div class="col-xl-6">
                        <div class="form-group">
                            <label>E-mail </label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="flaticon-email icon-lg"></i>
                                    </span>
                                </div>
                                <input type="email" class="form-control" id="email" name="email" ng-model="pharmacie.email" placeholder="E-mail de la pharmacie..."/>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label for="nom_pharmacie">Boite postale</label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="flaticon-edit icon-lg"></i>
                                    </span>
                                </div>
                                <input type="text" onkeyup="this.value = this.value.charAt(0).toUpperCase() + this.value.substr(1);" class="form-control" id="boite_postale" name="boite_postale" ng-model="pharmacie.boite_postale"  placeholder="Boite postale de la pharmacie"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-4">
                        <div class="form-group">
                            <label for="contact2">Latitude </label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="flaticon2-pin icon-lg"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" id="latitude" name="latitude" ng-model="pharmacie.latitude" placeholder="Latitude..."/>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="form-group">
                            <label>Longitude </label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="flaticon2-pin icon-lg"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" id="longitude" name="longitude" ng-model="pharmacie.longitude" placeholder="Longitude..."/>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="form-group">
                            <label>Logo </label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="flaticon-upload icon-lg"></i>
                                    </span>
                                </div>
                                <input type="file" class="form-control" name="logo"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label>Responsable *</label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="flaticon2-user icon-lg"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" id="responsable" name="responsable" ng-model="pharmacie.responsable" placeholder="Responsable de la pharmacie..." required/>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label>Contact du Responsable *</label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="flaticon-support icon-lg"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" id="contact_responsable" name="contact_responsable" ng-model="pharmacie.contact_responsable" placeholder="Contact du responsable..." required/>
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
    
<!--Delete modal-->
<div class="modal fade bs-modal-delete" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="deleteForm" ng-controller="deleteFormCtrl" action="#">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white"> Confimation de la suppression</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close text-white"></i>
                    </button>
                </div>
                <div class="modal-body">
                   <input type="text" id="idPharmacieToDelete" ng-model="pharmacie.id" ng-hide="true" class="hidden"/>
                   @csrf
                  
                       <div class="d-flex align-items-center p-5">
                           <div class="mr-6">
                               <span class="svg-icon svg-icon-primary svg-icon-4x">
                                   <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="50px" height="50px" viewBox="0 0 24 24" version="1.1">
                                   <g stroke="none" stroke-width="1" fill="none" fill-place="evenodd">
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
                                   Etes vous certains de vouloir supprimer la pharmacie ? <br/> <b>@{{pharmacie.nom_pharmacie}}</b>
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
  
<script type="text/javascript">
     var add = true;
     var $table = jQuery("#table"), rows = [];
    
    smartApp.controller('addFormCtrl', function ($scope) {
        $scope.populateForm = function (pharmacie) {
            $scope.pharmacie = pharmacie;
        };
        $scope.initForm = function () {
            ajout = true;
            $scope.pharmacie = {};
        };
    });
    
   smartApp.controller('deleteFormCtrl', function ($scope) {
        $scope.populateForm = function (pharmacie) {
            $scope.pharmacie = pharmacie;
        };
        $scope.initForm = function () {
            $scope.pharmacie = {};
        };
    });

    $(function () {
        $table.on('load-success.bs.table', function (e, data) {
            rows = data.rows; 
        });
        $('#localite_id').select2({width: '100%', allowClear: true, placeholder: "Choisir une localité"});

        // phone number format
        $("#contact_pharmacie , #contact_responsable, #contact2, #faxe").inputmask("mask", {
            "mask": "99 99 99 99 99"
        });

        $("#btnModalAdd").on("click", function () {
            $("#localite_id").val('').trigger('change');
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
                var url = "{{route('parametre.pharmacies.store')}}";
            }else{
                var methode = 'POST';
                var url = "{{route('parametre.update.pharmacie')}}";
            }

            var formData = new FormData($(this)[0]);
            editPharmacieAction(methode, url, $(this), formData, $ajaxSpinner, $table, add);
        });

        $("#deleteForm").submit(function (e) {
            e.preventDefault();
            var id = $("#idPharmacieToDelete").val();
            var formData = $(this).serialize();
            var $ajaxLoader = $(".interrogation");
            deleteAction('pharmacies/' + id, formData, $ajaxLoader, $table);
        });
   
    });

    function updateRow(idPharmacie) {
        add = false;
        var $scope = angular.element($("#addForm")).scope();
        var pharmacie =_.findWhere(rows, {id: idPharmacie});
        $scope.$apply(function () {
            $scope.populateForm(pharmacie);
        });
        $("#localite_id").select2('val',[pharmacie.localite_id])
        $(".bs-modal-add").modal("show");
    }

    function deleteRow(idPharmacie) {
          var $scope = angular.element($("#deleteForm")).scope();
          var pharmacie =_.findWhere(rows, {id: idPharmacie});
           $scope.$apply(function () {
              $scope.populateForm(pharmacie);
          });
       $(".bs-modal-delete").modal("show");
    }

    function logoFormatter(logo){
         return logo ? "<a target='_blank' href='"+ logo +"'><img width='50' height='50' src='"+ logo +"'/></a>" : "";
    }

    function optionFormatter(id, row) {
        return '<button class="btn btn-xs btn-primary btn-icon" data-toggle="tooltip" data-theme="dark" title="Düzenle" onClick="javascript:updateRow(' + id + ');"><i class="la la-edit"></i></button>\n\
                <button class="btn btn-xs btn-danger btn-icon"  data-toggle="tooltip" data-theme="dark" title="Sil" onClick="javascript:deleteRow(' + id + ');"><i class="la la-trash"></i></button>';
    }

//Add action
function editPharmacieAction(methode, url, $formObject, formData, $ajaxSpinner, $table, add = true) {
     jQuery.ajax({
        type: methode,
        url: url,
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        success:function (response, textStatus, xhr){
            if (response.code === 1) {
                document.forms["addForm"].reset();
                if (add) { //creation
                    $table.bootstrapTable('refresh');
                } else { //Modification
                    $table.bootstrapTable('refresh');
                    $(".bs-modal-add").modal("hide");
                }

                $formObject.trigger('eventAdd', [response.data]);
                toastr.success(response.msg, "SMART ORDO");
                $("#localite_id").val('').trigger('change');
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
            $formObject.removeAttr("disabled");
            $ajaxSpinner.removeClass('spinner');
        },
        beforeSend: function () {
            $formObject.attr("disabled", true);
            $ajaxSpinner.addClass('spinner');
        },
        complete: function () {
            $ajaxSpinner.removeClass('spinner');
        },
    });
}
</script>
@endif
@endsection
