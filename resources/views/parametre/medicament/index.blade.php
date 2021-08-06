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
                        Liste des m&eacute;dicaments
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
                                       data-url="{{url('parametre',['action'=>'liste-medicaments'])}}"
                                       data-unique-id="id"
                                       data-show-toggle="false"
                                       data-show-columns="true">
                                    <thead>
                                        <tr role="row">
                                            <th data-field="denomination" data-sortable="true" data-searchable="true">D&eacute;nomination</th>
                                            <th data-field="composition_quantitative">Composition</th>
                                            <th data-field="categorie.libelle_categorie">Cat&eacute;gorie</th>
                                            <th data-field="sous_categorie.libelle_categorie">Sous cat&eacute;gorie</th>
                                            <th data-field="forme.libelle_forme">Forme</th>
                                            <th data-field="emballage.libelle_emballage">Emballage</th>
                                            <th data-field="mode.libelle_mode">Mode</th>
                                            <th data-field="description" data-visible="false">Description</th>
                                            <th data-field="numero_autorisation" data-visible="false">N° Autorisation</th>
                                            <th data-field="image" data-formatter="imageFormatter">Image</th>
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
                <h5 class="modal-title text-white">Gestion des m&eacute;dicaments</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close text-white"></i>
                </button>
            </div>
            <input type="hidden" name="idMedicament" value="@{{medicament.id}}" class="hidden" ng-hide="true"/>
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-xl-8">
                        <div class="form-group">
                            <label for="nom_pharmacie">Nom du m&eacute;dicament *</label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="flaticon-apps icon-lg"></i>
                                    </span>
                                </div>
                                <input type="text" onkeyup="this.value = this.value.charAt(0).toUpperCase() + this.value.substr(1);" class="form-control" id="denomination" name="denomination" ng-model="medicament.denomination"  placeholder="DOLIPRANE..." required/>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="form-group">
                            <label for="nom_pharmacie">Quantit&eacute; *</label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="flaticon-map icon-lg"></i>
                                    </span>
                                </div>
                                <input type="text" onkeyup="this.value = this.value.charAt(0).toUpperCase() + this.value.substr(1);" class="form-control" id="composition_quantitative" name="composition_quantitative" ng-model="medicament.composition_quantitative"  placeholder="500 mg..." required/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-4">
                        <div class="form-group">
                            <label for="localite_id">Emballage *</label>
                            <div class="input-group input-group-sm">
                                <select class="form-control" id="emballage_id" ng-model="medicament.emballage_id" name="emballage_id" required>
                                    <option value=""> Selectionner un emballage</option>
                                    @foreach($emballages as $emballage)
                                        <option value="{{$emballage->id}}"> {{$emballage->libelle_emballage}}</option>
                                    @endforeach
                                </select> 
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="form-group">
                            <label for="localite_id">Forme *</label>
                            <div class="input-group input-group-sm">
                                <select class="form-control" id="forme_id" ng-model="medicament.forme_id" name="forme_id" required>
                                    <option value=""> Selectionner une forme</option>
                                    @foreach($formes as $forme)
                                        <option value="{{$forme->id}}"> {{$forme->libelle_forme}}</option>
                                    @endforeach
                                </select> 
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="form-group">
                            <label for="localite_id">Mode administration *</label>
                            <div class="input-group input-group-sm">
                                <select class="form-control" id="mode_administration_id" ng-model="medicament.mode_administration_id" name="mode_administration_id" required>
                                    <option value=""> Selectionner un mode </option>
                                    @foreach($modes as $mode)
                                        <option value="{{$mode->id}}"> {{$mode->libelle_mode}}</option>
                                    @endforeach
                                </select> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label for="localite_id">Cat&eacute;gorie *</label>
                            <div class="input-group input-group-sm">
                                <select class="form-control" id="categorie_id" name="categorie_id" required>
                                    <option value=""> Selectionner une cat&eacute;gorie</option>
                                    @foreach($categories as $categorie)
                                        <option value="{{$categorie->id}}"> {{$categorie->libelle_categorie}}</option>
                                    @endforeach
                                </select> 
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label for="localite_id">Sous cat&eacute;gorie </label>
                            <div class="input-group input-group-sm">
                                <select class="form-control" data-placeholder="Selectionner une sous catégorie" id="sous_categorie_id" name="sous_categorie_id">
                                </select> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-8">
                        <div class="form-group">
                            <label for="nom_pharmacie">N° d'autorisation </label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="flaticon2-medical-records icon-lg"></i>
                                    </span>
                                </div>
                                <input type="text" onkeyup="this.value = this.value.charAt(0).toUpperCase() + this.value.substr(1);" class="form-control" id="numero_autorisation" name="numero_autorisation" ng-model="medicament.numero_autorisation"  placeholder="Numéro d'autorisation..."/>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="form-group">
                            <label>Image </label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="flaticon-upload icon-lg"></i>
                                    </span>
                                </div>
                                <input type="file" class="form-control" name="image"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" onkeyup="this.value = this.value.charAt(0).toUpperCase() + this.value.substr(1);" id="description" name="description" rows="3" placeholder="Description et indication thérapeutique..." ng-model="medicament.description"></textarea>
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
                   <input type="text" id="idMedicamentToDelete" ng-model="medicament.id" ng-hide="true" class="hidden"/>
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
                                   Etes vous certains de vouloir supprimer le medicament ? <br/> <b>@{{medicament.denomination}}</b>
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
        $scope.populateForm = function (medicament) {
            $scope.medicament = medicament;
        };
        $scope.initForm = function () {
            ajout = true;
            $scope.medicament = {};
        };
    });
    
   smartApp.controller('deleteFormCtrl', function ($scope) {
        $scope.populateForm = function (medicament) {
            $scope.medicament = medicament;
        };
        $scope.initForm = function () {
            $scope.medicament = {};
        };
    });

    $(function () {
        $table.on('load-success.bs.table', function (e, data) {
            rows = data.rows; 
        });

        $('#categorie_id').select2({width: '100%', allowClear: true});

        $("#btnModalAdd").on("click", function () {
            $("#categorie_id, #sous_categorie_id").val('').trigger('change');
        });

        $("#categorie_id").change(function (e) { 
            var categorie_id = $("#categorie_id").val();
            $.getJSON("../parametre/liste-sous-categories-by-categorie/" + categorie_id, function (reponse) {
                $('#sous_categorie_id').html("<option value=''>-- Selectionner une sous catégorie --</option>");
                if(reponse.total>0){
                    $.each(reponse.rows, function (index, sous_categories) { 
                        $('#sous_categorie_id').append('<option value=' + sous_categories.id + '>' + sous_categories.libelle_categorie + '</option>')
                    });
                }else{
                    $('#sous_categorie_id').html("<option value=''>-- Aucune sous catégorie trouvée --</option>");
                }
            })
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
                var url = "{{route('parametre.medicaments.store')}}";
            }else{
                var methode = 'POST';
                var url = "{{route('parametre.update.medicament')}}";
            }

            var formData = new FormData($(this)[0]);
            editMedicamentAction(methode, url, $(this), formData, $ajaxSpinner, $table, add);
        });

        $("#deleteForm").submit(function (e) {
            e.preventDefault();
            var id = $("#idMedicamentToDelete").val();
            var formData = $(this).serialize();
            var $ajaxLoader = $(".interrogation");
            deleteAction('medicaments/' + id, formData, $ajaxLoader, $table);
        });
   
    });

    function updateRow(idMedicament) {
        add = false;
        var $scope = angular.element($("#addForm")).scope();
        var medicament =_.findWhere(rows, {id: idMedicament});
        $scope.$apply(function () {
            $scope.populateForm(medicament);
        });

        $("#categorie_id").select2('val',[medicament.categorie_id]);
  
        if(medicament.sous_categorie_id!=null){
            $.getJSON("../parametre/liste-sous-categories-by-categorie/" + medicament.categorie_id, function (reponse) {
                $('#sous_categorie_id').html("<option value=''>-- Selectionner une sous catégorie --</option>");
                if(reponse.total>0){
                    $.each(reponse.rows, function (index, sous_categories) { 
                        $('#sous_categorie_id').append('<option value=' + sous_categories.id + '>' + sous_categories.libelle_categorie + '</option>')
                    });
                    $("#sous_categorie_id").val(medicament.sous_categorie_id);
                }else{
                    $('#sous_categorie_id').html("<option value=''>-- Aucune sous catégorie trouvée --</option>");
                }
            })
        }
          
        $(".bs-modal-add").modal("show");
    }

    function deleteRow(idMedicament) {
          var $scope = angular.element($("#deleteForm")).scope();
          var medicament =_.findWhere(rows, {id: idMedicament});
           $scope.$apply(function () {
              $scope.populateForm(medicament);
          });
       $(".bs-modal-delete").modal("show");
    }

    function imageFormatter(image){
         return image ? "<a target='_blank' href='"+ image +"'><img width='50' height='50' src='"+ image +"'/></a>" : "";
    }

    function optionFormatter(id, row) {
        return '<button class="btn btn-xs btn-primary btn-icon" data-toggle="tooltip" data-theme="dark" title="Düzenle" onClick="javascript:updateRow(' + id + ');"><i class="la la-edit"></i></button>\n\
                <button class="btn btn-xs btn-danger btn-icon"  data-toggle="tooltip" data-theme="dark" title="Sil" onClick="javascript:deleteRow(' + id + ');"><i class="la la-trash"></i></button>';
    }

//Add action
function editMedicamentAction(methode, url, $formObject, formData, $ajaxSpinner, $table, add = true) {
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
                $("#categorie_id, #sous_categorie_id").val('').trigger('change');
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
