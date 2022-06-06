
@if ($type == 1 or $type == 2)
<div class="container" style="font-family: 'Prompt', sans-serif;">
    <div class="modal-header bg-info">
        @if ($type == 1)
            <h5 class="modal-title">รายงาน อนุมัติตั้งเบิกประจำวัน</h5>
        @elseif($type == 2)
            <h5 class="modal-title">รายงาน อนุมัติตั้งเบิกพิเศษ</h5>
        @endif
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
    <form name="form1" action="{{ route('MasterTreasury.show',0) }}" target="_blank" method="get" id="formimage" enctype="multipart/form-data">
        <div class="modal-body text-sm">
            @csrf
            <div class="row">
                <div class="col-6">
                    <div class="form-group row mb-1">
                        <label class="col-sm-4 col-form-label text-right">จากวันที่ :</label>
                        <div class="col-sm-8">
                            <input type="date" name="Fromdate" value="{{ date('Y-m-d') }}" class="form-control form-control-sm"/>
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label class="col-sm-4 col-form-label text-right">ถึงวันที่ :</label>
                        <div class="col-sm-8">
                            <input type="date" name="Todate" value="{{ date('Y-m-d') }}" class="form-control form-control-sm"/>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group row mb-1">
                        <label class="col-sm-3 col-form-label text-right">รหัสผู้รับ :</label>
                        <div class="col-sm-8">
                            <select name="user" class="form-control form-control-sm">
                                <option value="" selected>--- รหัสผู้รับ ---</option>
                                <option value="จิราพร สุขะพัฒน์" >01. จิราพร สุขะพัฒน์</option>
                                <option value="กานต์พิชชา ชัยจิต" >02. กานต์พิชชา ชัยจิต</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-sm btn-info">
                <i class="fas fa-print"></i> พิมพ์
            </button>
        </div>

        <input type="hidden" name="type" value="{{$type}}" />
        <input type="hidden" name="_token" value="{{csrf_token()}}" />
    </form>
</div>

@endif