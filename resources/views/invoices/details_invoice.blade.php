@extends('layouts.master')
@section('css')
<!---Internal  Prism css-->
<link href="{{URL::asset('assets/plugins/prism/prism.css')}}" rel="stylesheet">
<!---Internal Input tags css-->
<link href="{{URL::asset('assets/plugins/inputtags/inputtags.css')}}" rel="stylesheet">
<!--- Custom-scroll -->
<link href="{{URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.css')}}" rel="stylesheet">
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
                <div class="d-flex">
                        <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تفاصيل الفاتوره</span>
                </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
                <div class="pr-1 mb-3 mb-xl-0">
                </div>

                <div class="mb-3 mb-xl-0">
                    
 

                </div>
        </div>
</div>
				<!-- breadcrumb -->
@endsection
@section('content')
                <!-- row -->
<div class="row">
    <div class="col-xl-12">
        <!-- div -->
        <div class="card mg-b-20" id="tabs-style2">
            <div class="card-body">
                <div class="main-content-label mg-b-5">
                    <p>
                        التفاصيل الخاصه بالفاتوره
                    </p>
                </div>
                   @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    @if (session()->has('Add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Add') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif



    @if (session()->has('delete'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('delete') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
                <div class="text-wrap">
                <div class="example">
                    <div class="panel panel-primary tabs-style-2">
                        <div class=" tab-menu-heading">
                                <div class="tabs-menu1">
                                        <!-- Tabs -->
                                        <ul class="nav panel-tabs main-nav-line">
                                                <li><a href="#tab4" class="nav-link active" data-toggle="tab">تفاصيل الفاتوره </a></li>
                                                <li><a href="#tab5" class="nav-link" data-toggle="tab">حالات الدفع</a></li>
                                                <li><a href="#tab6" class="nav-link" data-toggle="tab">المرفقات</a></li>
                                        </ul>
                                </div>
                        </div>
                        <div class="panel-body tabs-menu-body main-content-body-right border">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab4">
                                    <div class="col-xl-12">
                                    <div class="card">
                                            <div class="card-body">
                                                <div class="table-responsive-lg">
                                                    <table class="table table-bordered" style="text-align:center">
                                                        <thead>
                                                            <tr class="table-primary">
                                                                <th  scope="col">رقم الفاتوره</th>
                                                                <td style="background-color: background;" scope="row">{{ $invoice->invoice_number }}</td>
                                                                <th scope="col">تاريخ الاصدار</th>
                                                                <td style="background-color: background;"  scope="row">{{ $invoice->invoice_date }}</td>
                                                                <th scope="col">تاريخ الاستحقاق</th>
                                                                <td style="background-color: background;"  scope="row">{{ $invoice->due_date }}</td>
                                                                <th scope="col">القسم</th>
                                                                <td  style="background-color: background;" scope="row">{{ $invoice->section->section_name }}</td>
                                                            </tr>
                                                            <tr class="table-primary">
                                                                <th scope="row">المنتج</th>
                                                                <td style="background-color: background;" >{{ $invoice->product }}</td>
                                                                <th scope="row">مبلغ التحصيل</th>
                                                                <td style="background-color: background;" >{{ $invoice->Amount_collection }}</td>
                                                                <th scope="row">مبلغ العمولة</th>
                                                                <td style="background-color: background;" >{{ $invoice->Amount_Commission }}</td>
                                                                <th scope="row">الخصم</th>
                                                                <td style="background-color: background;" >{{ $invoice->Discount }}</td>
                                                            </tr>


                                                        <tr class="table-primary">
                                                            <th scope="row">نسبة الضريبة</th>
                                                            <td style="background-color: background;" >{{ $invoice->Rate_VAT }}</td>
                                                            <th scope="row">قيمة الضريبة</th>
                                                            <td style="background-color: background;" >{{ $invoice->Value_VAT }}</td>
                                                            <th scope="row">الاجمالي مع الضريبة</th>
                                                            <td style="background-color: background;" >{{ $invoice->Total }}</td>
                                                            <th scope="row">الحالة الحالية</th>

                                                            @if ($invoice->Value_Status == 1)
                                                                <td style="background-color: background;" ><span
                                                                        class="badge badge-pill badge-success">{{ $invoice->status }}</span>
                                                                </td>
                                                            @elseif($invoice->Value_Status ==2)
                                                                <td style="background-color: background;" ><span
                                                                        class="badge badge-pill badge-danger">{{ $invoice->status }}</span>
                                                                </td>
                                                            @else
                                                                <td style="background-color: background;" ><span
                                                                        class="badge badge-pill badge-warning">{{ $invoice->status }}</span>
                                                                </td>
                                                            @endif
                                                        </tr>

                                                        <tr>
                                                            <th scope="row">ملاحظات</th>
                                                            <td style="background-color: background;" >{{ $invoice->note }}</td>
                                                        </tr>
                                                        </thead>
                                                    </table>
                                                    </div><!-- bd -->
                                            </div><!-- bd -->
                                        </div><!-- bd -->
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab5">
                                    <div class="table-responsive mt-15">
                                    <table class="table center-aligned-table mb-0 table-hover"
                                        style="text-align:center">
                                        <thead>
                                            <tr class="text-dark">
                                                <th>#</th>
                                                <th>رقم الفاتورة</th>
                                                <th>نوع المنتج</th>
                                                <th>القسم</th>
                                                <th>حالة الدفع</th>
                                                <th>تاريخ الدفع </th>
                                                <th>ملاحظات</th>
                                                <th>تاريخ الاضافة </th>
                                                <th>المستخدم</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 0; ?>
                                            @foreach ($invoice_details as $x)
                                            <?php $i++; ?>
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $x->invoice_number }}</td>
                                                <td>{{ $x->product }}</td>
                                                <td>{{ $invoice->section->section_name }}</td>
                                                @if ($x->Value_Status == 1)
                                                    <td><span
                                                            class="badge badge-pill badge-success">{{ $x->Status }}</span>
                                                    </td>
                                                @elseif($x->Value_Status ==2)
                                                    <td><span
                                                            class="badge badge-pill badge-danger">{{ $x->Status }}</span>
                                                    </td>
                                                @else
                                                    <td><span
                                                            class="badge badge-pill badge-warning">{{ $x->Status }}</span>
                                                    </td>
                                                @endif
                                                <td>{{ $x->Payment_Date }}</td>
                                                <td>{{ $x->note }}</td>
                                                <td>{{ $x->created_at }}</td>
                                                <td>{{ $x->user }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>


                                </div>
                                </div>
                                <div class="tab-pane" id="tab6">
                                            <!--المرفقات-->
                                    <div class="card card-statistics">
                                            <div class="card-body">
                                                <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                                                <h5 class="card-title">اضافة مرفقات</h5>
                                                <form method="post" action="{{ url('/InvoiceAttachments') }}"
                                                    enctype="multipart/form-data">
                                                    {{ csrf_field() }}
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="customFile"
                                                            name="file_name" required>
                                                        <input type="hidden" id="customFile" name="invoice_number"
                                                            value="{{ $invoice->invoice_number }}">
                                                        <input type="hidden" id="invoice_id" name="invoice_id"
                                                            value="{{ $invoice->id }}">
                                                        <label class="custom-file-label" for="customFile">حدد
                                                            المرفق</label>
                                                    </div><br><br>
                                                    <button type="submit" class="btn btn-primary btn-sm "
                                                        name="uploadedFile">تاكيد</button>
                                                </form>
                                            </div>
                                        <br>

                                        <div class="table-responsive mt-15">
                                            <table class="table center-aligned-table mb-0 table table-hover"
                                                style="text-align:center">
                                                <thead>
                                                    <tr class="text-dark">
                                                        <th scope="col">م</th>
                                                        <th scope="col">اسم الملف</th>
                                                        <th scope="col">قام بالاضافة</th>
                                                        <th scope="col">تاريخ الاضافة</th>
                                                        <th scope="col">العمليات</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php $i = 0; ?>
                                                 @foreach ($invoice_attachments as $attachment)
                                                                <?php $i++; ?>
                                                                <tr>
                                                                    <td>{{ $i }}</td>
                                                                    <td>{{ $attachment->file_name }}</td>
                                                                    <td>{{ $attachment->Created_by }}</td>
                                                                    <td>{{ $attachment->created_at }}</td>
                                                                    <td colspan="2">

                                                                        <a class="btn btn-outline-success btn-sm"
                                                                            href="{{ url('View_file') }}/{{ $invoice->invoice_number }}/{{ $attachment->file_name }}"
                                                                            role="button"><i class="fas fa-eye"></i>&nbsp;
                                                                            عرض</a>

                                                                        <a class="btn btn-outline-info btn-sm"
                                                                            href="{{ url('download') }}/{{ $invoice->invoice_number }}/{{ $attachment->file_name }}"
                                                                            role="button"><i
                                                                                class="fas fa-download"></i>&nbsp;
                                                                            تحميل</a>
  
                                                                            <button class="btn btn-outline-danger btn-sm"
                                                                                data-toggle="modal"
                                                                                data-file_name="{{ $attachment->file_name }}"
                                                                                data-invoice_number="{{ $attachment->invoice_number }}"
                                                                                data-id_file="{{ $attachment->id }}"
                                                                                data-target="#delete_file">حذف
                                                                            </button>
                                                                     </td>
                                                                </tr>
                                                            @endforeach
                                                </tbody>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /div -->
        </div>
                                    </div>
   
<!---Prism Pre code--> 

                                                        
                     <!-- row closed -->
        </div>
        <!-- Container closed -->
</div>


 <!-- delete -->
    <div class="modal fade" id="delete_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">حذف المرفق</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('delete_file') }}" method="post">

                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p class="text-center">
                        <h6 style="color:red"> هل انت متاكد من عملية حذف المرفق ؟</h6>
                        </p>

                        <input type="hidden" name="id_file" id="id_file" value="">
                        <input type="hidden" name="file_name" id="file_name" value="">
                        <input type="hidden" name="invoice_number" id="invoice_number" value="">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-danger">تاكيد</button>
                    </div>
                </form>
            </div>
        </div>            </div>
        </div>
		<!-- main-content closed -->
@endsection
@section('js')
<!--Internal  Datepicker js -->
<script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
<!-- Internal Select2 js-->
<script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<!-- Internal Jquery.mCustomScrollbar js-->
<script src="{{URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<!-- Internal Input tags js-->
<script src="{{URL::asset('assets/plugins/inputtags/inputtags.js')}}"></script>
<!--- Tabs JS-->
<script src="{{URL::asset('assets/plugins/tabs/jquery.multipurpose_tabcontent.js')}}"></script>
<script src="{{URL::asset('assets/js/tabs.js')}}"></script>
<!--Internal  Clipboard js-->
<script src="{{URL::asset('assets/plugins/clipboard/clipboard.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/clipboard/clipboard.js')}}"></script>
<!-- Internal Prism js-->
<script src="{{URL::asset('assets/plugins/prism/prism.js')}}"></script>

<script>
        $('#delete_file').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id_file = button.data('id_file')
            var file_name = button.data('file_name')
            var invoice_number = button.data('invoice_number')
            var modal = $(this)
            modal.find('.modal-body #id_file').val(id_file);
            modal.find('.modal-body #file_name').val(file_name);
            modal.find('.modal-body #invoice_number').val(invoice_number);
        })
    </script>
@endsection