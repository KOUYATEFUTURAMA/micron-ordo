@extends('layouts.app')
@section('content')
@if(Auth::user()->role == 'Administrateur' or Auth::user()->role == 'Concepteur')
<script src="{{asset('js/crud.js')}}"></script>
<script src="{{asset('plugins/jQuery/jquery.validate.min.js')}}"></script>
<script src="{{asset('plugins/bootstrap-table/dist/bootstrap-table.min.js')}}"></script>
<script src="{{asset('plugins/bootstrap-table/dist/locale/bootstrap-table-fr-FR.min.js')}}"></script>
<script src="{{asset('plugins/js/underscore-min.js')}}"></script>
<!--<script src="{{asset('template/plugins/custom/datatables/datatables.bundle.js')}}"></script>-->

<!--<link href="{{asset('template/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet">-->
<link href="{{asset('plugins/bootstrap-table/dist/bootstrap-table.min.css')}}" rel="stylesheet">
<div class="row">    
    <div class="col-xl-5">
        <div class="card card-custom">
            <div class="card-header">
                <h3 class="card-title">
                    {{$titleControlleur}}
                </h3>
            </div>
            <form id="addForm" ng-controller="addFormCtrl" action="#">
                <input type="hidden" id="idModeToModify" value="@{{mode.id}}" class="hidden" ng-hide="true"/>
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label>Nom du mode d'administration *</label>
                        <input type="text" class="form-control" name="libelle_mode" id="libelle_mode" ng-model="mode.libelle_mode" onkeyup="this.value = this.value.charAt(0).toUpperCase() + this.value.substr(1);" placeholder="Orale..." required/>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary mr-2 spinner spinner-white spinner-right btn-add">Valider</button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="col-xl-7">
        <div class="card card-custom">
            <div class="card-header">
                <h3 class="card-title">
                     Liste des modes d'administration
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
                                    data-url="{{url('parametre',['action'=>'liste-modes'])}}"
                                    data-unique-id="id"
                                    data-show-toggle="false">
                                <thead>
                                    <tr role="row">
                                        <th data-field="libelle_mode" data-searchable="true">Nom du mode</th>
                                        <th data-field="id" data-formatter="optionFormatter" data-width="100px" data-align="center">Option</th>
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
                   <input type="text" id="idModeToDelete" ng-model="mode.id" ng-hide="true" class="hidden"/>
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
                                   Etes vous certains de vouloir supprimer le mode ? <br/> <b>@{{mode.libelle_mode}}</b>
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
        $scope.populateForm = function (mode) {
            $scope.mode = mode;
        };
        $scope.initForm = function () {
            ajout = true;
            $scope.mode = {};
        };
    });
    
    smartApp.controller('deleteFormCtrl', function ($scope) {
        $scope.populateForm = function (mode) {
            $scope.mode = mode;
        };
        $scope.initForm = function () {
            $scope.mode = {};
        };
    });
    
    $(function () {
        $table.on('load-success.bs.table', function (e, data) {
            rows = data.rows; 
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
                var url = "{{route('parametre.modes.store')}}";
            }else{
                var id = $("#idModeToModify").val();
                var methode = 'PUT';
                var url = 'modes/' + id;
             }
            editAction(methode, url, $(this), $(this).serialize(), $ajaxSpinner, $table, add);
        });
        
        $("#deleteForm").submit(function (e) {
            e.preventDefault();
            var id = $("#idModeToDelete").val();
            var formData = $(this).serialize();
            var $ajaxLoader = $(".interrogation");
            deleteAction('modes/' + id, formData, $ajaxLoader, $table);
        });
    });

    function updateRow(idMode) {
        add = false;
        var $scope = angular.element($("#addForm")).scope();
        var mode =_.findWhere(rows, {id: idMode});
        $scope.$apply(function () {
            $scope.populateForm(mode);
        });
    }
    
    function deleteRow(idMode) {
          var $scope = angular.element($("#deleteForm")).scope();
          var mode =_.findWhere(rows, {id: idMode});
           $scope.$apply(function () {
              $scope.populateForm(mode);
          });
       $(".bs-modal-delete").modal("show");
    }

    
    function optionFormatter(id, row) {
        return '<button class="btn btn-xs btn-primary btn-icon" data-toggle="tooltip" data-theme="dark" title="Düzenle" onClick="javascript:updateRow(' + id + ');"><i class="la la-edit"></i></button>\n\
                <button class="btn btn-xs btn-danger btn-icon"  data-toggle="tooltip" data-theme="dark" title="Sil" onClick="javascript:deleteRow(' + id + ');"><i class="la la-trash"></i></button>';
    }
</script>
@endif
@endsection


