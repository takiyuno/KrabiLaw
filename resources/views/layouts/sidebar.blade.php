@php
  function active($currect_page) {
    $url_array =  explode('/', $_SERVER['REQUEST_URI']) ;
    $url = end($url_array);
    if($currect_page == $url) {
      echo 'active'; //class name in css
    }
  }
@endphp

  <style>
    .SizeText{
      font-size: 13px;
    }
  </style>

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4 sidebar-dark-info" style="font-family: 'Prompt', sans-serif;">
    <!-- Brand Logo -->
    <a href="{{ route('index','home') }}" class="brand-link">
      <img src="{{ asset('dist/img/LAW.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">CHOOKIAT LAW</span>
    </a>

    <!-- Active Tab -->
    @php
      if (isset($_GET['type']) and Request::is('MasterLegis') or Request::is('MasterLegis/*')) {
        $SetMasterLegis = true;
        if ($_GET['type'] == 20 || $_GET['type'] == 24) {
          $SetActive20 = true;
        }elseif ($_GET['type'] == 3) {
          $SetActive3 = true;
        }elseif ($_GET['type'] == 4) {
          $SetActive4 = true;
        }elseif ($_GET['type'] == 5) {
          $SetActive5 = true;
        }elseif ($_GET['type'] == 6) {
          $SetMasterLegisLand = true;
          $SetMasterLegis = false;
          $SetActive6 = true;
        }elseif ($_GET['type'] == 7) {
          $SetMasterLegisClose = true;
          $SetMasterLegis = false;
          $SetActive7 = true;
        }elseif ($_GET['type'] == 8) {
          $SetMasterExhibit = true;
          $SetMasterLegis = false;
          $SetMasterLegisClose = false;
          $SetActive8 = true;
        }
      }
      elseif (isset($_GET['type']) and Request::is('MasterCompro') or Request::is('MasterCompro/*')){
        $SetMasterCompro = true;
        if ($_GET['type'] == 2) {
          $SetCompro2 = true;
        }elseif ($_GET['type'] == 3) {
          $SetCompro3 = true;
        }elseif ($_GET['type'] == 4) {
          $SetCompro4 = true;
        }elseif ($_GET['type'] == 5) {
          $SetCompro5 = true;
        }elseif ($_GET['type'] == 6) {
          $SetCompro6 = true;
        }
      }
      elseif (isset($_GET['type']) and Request::is('MasterBook')){
        $SetMasterBook = true;
        if ($_GET['type'] == 1) {
          $SetBookActive1 = true;
        }elseif ($_GET['type'] == 2) {
          $SetBookActive2 = true;
        }elseif ($_GET['type'] == 3) {
          $SetBookActive3 = true;
        }
      }
      elseif (isset($_GET['type']) and Request::is('MasterExpense') or Request::is('MasterExpense/*')){
        $SetMasterExpense = true;
        if ($_GET['type'] == 1) {
          $SetExpenseActive1 = true;
        }elseif ($_GET['type'] == 2) {
          $SetExpenseActive2 = true;
        }elseif ($_GET['type'] == 3) {
          $SetExpenseActive3 = true;
        }
      }
      elseif (isset($_GET['type']) and Request::is('MasterTreasury') or Request::is('MasterTreasury/*')){
        $SetMasterTreasury = true;
        if ($_GET['type'] == 1) {
          $SetTreasuryActive1 = true;
        }elseif ($_GET['type'] == 2) {
          $SetTreasuryActive2 = true;
        }elseif ($_GET['type'] == 3) {
          $SetTreasuryActive3 = true;
        }
      }
    @endphp

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('dist/img/AdminLTELogo.png') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->username }}</a>
        </div>
      </div> -->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column text-sm" data-widget="treeview" role="menu" data-accordion="false">
          
        @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์" or auth::user()->type == "แผนก กฏหมาย")
          <li class="nav-item has-treeview @if(isset($SetMasterLegis)) {{($SetMasterLegis == true) ? 'menu-open' : '' }} @endif">
            <a href="#" class="nav-link SizeText active">
              <i class="nav-icon fas fa-gavel"></i>
              <p>
                ระบบกฏหมาย
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="margin-left: 15px;">
              <li class="nav-item">
                <a data-toggle="modal" data-target="#modal-1" data-link="{{ route('MasterLegis.index') }}?type={{1}}" class="nav-link SizeText {{ Request::is('Legislation/Home/1') ? 'active' : '' }}">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>รายชื่อลูกหนี้</p>
                </a>
                <a href="{{ route('MasterLegis.index') }}?type={{3}}" class="nav-link SizeText @if(isset($SetActive3)) {{($SetActive3 == true) ? 'active' : '' }} @endif">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>ลูกหนี้ ชั้นเตรียมฟ้อง</p>
                </a>
                <a href="{{ route('MasterLegis.index') }}?type={{4}}" class="nav-link SizeText @if(isset($SetActive4)) {{($SetActive4 == true) ? 'active' : '' }} @endif">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>ลูกหนี้ ชั้นศาล</p>
                </a>
                <a href="{{ route('MasterLegis.index') }}?type={{5}}" class="nav-link SizeText @if(isset($SetActive5)) {{($SetActive5 == true) ? 'active' : '' }} @endif">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>ลูกหนี้ ชั้นบังคับคดี</p>
                </a>
                <!-- <a href="{{ route('MasterLegis.index') }}?type={{7}}" class="nav-link SizeText @if(isset($SetActive7)) {{($SetActive7 == true) ? 'active' : '' }} @endif">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>รายการลูกหนี้ปิดจบ</p>
                </a> -->
               
                <!-- <a href="{{ route('MasterLegis.index') }}?type={{20}}" class="nav-link SizeText @if(isset($SetActive20)) {{($SetActive20 == true) ? 'active' : '' }} @endif">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>ระบบลูกหนี้กฎหมาย</p>
                </a>
                <a href="{{ route('MasterLegis.index') }}?type={{10}}" class="nav-link SizeText @if(isset($SetActive10)) {{($SetActive10 == true) ? 'active' : '' }} @endif">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>ระบบลูกหนี้ของกลาง</p>
                </a> -->
              </li>
            </ul>
          </li>

          <li class="nav-item has-treeview @if(isset($SetMasterCompro)) {{($SetMasterCompro == true) ? 'menu-open' : '' }} @endif {{ Request::is('MasterCompro/*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link SizeText active">
              <i class="nav-icon fas fa-user-tag"></i>

              <p>ระบบลูกหนี้ประนอมหนี้ <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview" style="margin-left: 15px;">
              <!-- <li class="nav-item">
                <a href="{{ route('MasterCompro.index') }}?type={{1}}" class="nav-link SizeText @if(isset($SetCompro1)) {{($SetCompro1 == true) ? 'active' : '' }} @endif">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>ประเภทประนอมหนี้</p>
                </a>
              </li> -->
              <li class="nav-item">
                <a href="{{ route('MasterCompro.index') }}?type={{2}}" class="nav-link SizeText @if(isset($SetCompro2)) {{($SetCompro2 == true) ? 'active' : '' }} @endif">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>ลูกหนี้ประนอมใหม่</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('MasterCompro.index') }}?type={{3}}" class="nav-link SizeText @if(isset($SetCompro3)) {{($SetCompro3 == true) ? 'active' : '' }} @endif">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>ลูกหนี้ประนอมเก่า</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('MasterCompro.index') }}?type={{5}}" class="nav-link SizeText @if(isset($SetCompro5)) {{($SetCompro5 == true) ? 'active' : '' }} @endif">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>รายการติดตามลูกหนี้</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('MasterCompro.index') }}?type={{6}}" class="nav-link SizeText @if(isset($SetCompro6)) {{($SetCompro6 == true) ? 'active' : '' }} @endif">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>รายการรับชำระค่างวด</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('MasterCompro.index') }}?type={{4}}" class="nav-link SizeText @if(isset($SetCompro4)) {{($SetCompro4 == true) ? 'active' : '' }} @endif">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>แจ้งเตือนขาดชำระลูกหนี้</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item has-treeview @if(isset($SetMasterLegisLand)) {{($SetMasterLegisLand == true) ? 'menu-open' : '' }} @endif">
            <a href="#" class="nav-link SizeText active">
              <i class="nav-icon fas fa-file-invoice-dollar"></i>
              <p>ระบบลูกหนี้สินทรัพย์ <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview" style="margin-left: 15px;">
              <li class="nav-item">
                <a href="{{ route('MasterLegis.index') }}?type={{6}}" class="nav-link SizeText @if(isset($SetActive6)) {{($SetActive6 == true) ? 'active' : '' }} @endif">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>รายการสินทรัพย์</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item has-treeview @if(isset($SetMasterLegisClose)) {{($SetMasterLegisClose == true) ? 'menu-open' : '' }} @endif">
            <a href="#" class="nav-link SizeText active">
              <i class="nav-icon fas fa-bell"></i>
              <p>ระบบลูกหนี้จบงานฟ้อง <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview" style="margin-left: 15px;">
              <li class="nav-item">
                <a href="{{ route('MasterLegis.index') }}?type={{7}}" class="nav-link SizeText @if(isset($SetActive7)) {{($SetActive7 == true) ? 'active' : '' }} @endif">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>รายการลูกหนี้จบงาน</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item has-treeview @if(isset($SetMasterExhibit)) {{($SetMasterExhibit == true) ? 'menu-open' : '' }} @endif">
            <a href="#" class="nav-link SizeText active">
              <i class="nav-icon fas fa-bezier-curve"></i>
              <p>ระบบลูกหนี้ของกลาง <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview" style="margin-left: 15px;">
              <li class="nav-item">
                <a href="{{ route('MasterLegis.index') }}?type={{8}}" class="nav-link SizeText @if(isset($SetActive8)) {{($SetActive8 == true) ? 'active' : '' }} @endif">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>รายการลูกหนี้ของกลาง</p>
                </a>
              </li>
            </ul>
          </li>

          {{--<li class="nav-item has-treeview">
            <a href="#" class="nav-link SizeText active">
              <i class="nav-icon fas fa-bell"></i>
              <p>
                แจ้งเตือนงานกกฏหมาย
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>

            <ul class="nav nav-treeview" style="margin-left: 15px;">
              <li class="nav-item">
                <a href="{{ route('MasterCompro.index') }}?type={{4}}" class="nav-link SizeText">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>แจ้งเตือนประนอมเช่าซื้อ</p>
                </a>
              </li>
            </ul>
          </li>--}}

          {{--<li class="nav-item has-treeview {{ Request::is('Precipitate/*') ? 'menu-open' : '' }} {{ Request::is('MasterPrecipitate/*') ? 'menu-open' : '' }} {{ Request::is('Analysis/deleteImageEach/11/*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link SizeText active">
              <i class="nav-icon far fa-handshake"></i>
              <p>
                ระบบเร่งรัด
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link SizeText">
                  <i class="far fa-window-restore text-red nav-icon"></i>
                  <p>
                    ระบบ
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview" style="margin-left: 15px;">
                  <li class="nav-item">
                    <a href="{{ route('Precipitate',3) }}" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>ระบบแจ้งเตือนติดตาม</p>
                    </a>
                    <a href="{{ route('Precipitate',1) }}" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>ระบบปล่อยงาน</p>
                    </a>
                    <a href="{{ route('Precipitate',5) }}" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>ระบบสต็อกรถเร่งรัด</p>
                    </a>
                    <a href="{{ route('Precipitate',11) }}" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>ระบบปรับโครงสร้างหนี้</p>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>

            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link SizeText">
                  <i class="far fa-window-restore text-red nav-icon"></i>
                  <p>
                    รายงาน
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview" style="margin-left: 15px;">
                  <li class="nav-item">
                    <a href="{{ route('Precipitate',2) }}" class="nav-link SizeText">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>รายงาน แยกตามทีม</p>
                    </a>
                    <a href="{{ route('Precipitate',7) }}" class="nav-link SizeText">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>รายงาน งานประจำวัน</p>
                    </a>
                    <a href="{{ route('Precipitate',8) }}" class="nav-link SizeText">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>รายงาน รับชำระค่าติดตาม</p>
                    </a>
                    <a href="{{ route('Precipitate',9) }}" class="nav-link SizeText">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>รายงาน ใบรับฝาก</p>
                    </a>
                    <a href="{{ route('Precipitate',10) }}" class="nav-link SizeText">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>รายงาน หนังสือขอยืนยัน</p>
                    </a>
                    <a href="{{ route('Precipitate',15) }}" class="nav-link SizeText">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>รายงาน หนังสือทวงถาม</p>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </li>--}}

          <li class="nav-item has-treeview @if(isset($SetMasterExpense)) {{($SetMasterExpense == true) ? 'menu-open' : '' }} @endif {{ Request::is('MasterExpense/*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link SizeText active">
              <i class="nav-icon fas fa-money"></i>
              <p>
                ระบบค่าใช้จ่ายกฎหมาย
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>

            <ul class="nav nav-treeview" style="margin-left: 15px;">
              <li class="nav-item">
                <a href="{{ route('MasterExpense.index') }}?type={{1}}" class="nav-link SizeText @if(isset($SetExpenseActive1)) {{($SetExpenseActive1 == true) ? 'active' : '' }} @endif">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>รายการค่าใช้จ่าย</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item has-treeview @if(isset($SetMasterBook)) {{($SetMasterBook == true) ? 'menu-open' : '' }} @endif">
            <a href="#" class="nav-link SizeText active">
              <i class="nav-icon fas fa-address-book"></i>
              <p>
                ระบบหนังสือ
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>

              <ul class="nav nav-treeview" style="margin-left: 15px;">
                <li class="nav-item">
                    <a href="{{ route('MasterBook.index') }}?type={{1}}" class="nav-link SizeText @if(isset($SetBookActive1)) {{($SetBookActive1 == true) ? 'active' : '' }} @endif">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>หนังสือ สารบัญ</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('MasterBook.index') }}?type={{2}}" class="nav-link SizeText @if(isset($SetBookActive2)) {{($SetBookActive2 == true) ? 'active' : '' }} @endif">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>หนังสือ เข้า-ออก</p>
                    </a>
                </li>
                <!-- <li class="nav-item">
                    <a href="{{ route('MasterBook.index') }}?type={{3}}" class="nav-link  @if(isset($SetBookActive3)) {{($SetBookActive3 == true) ? 'active' : '' }} @endif">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>หนังสือ-ออก</p>
                    </a>
                </li> -->
              </ul>
          </li>
        @endif

        @if(auth::user()->type == "แผนก เร่งรัด")
          <li class="nav-item has-treeview @if(isset($SetMasterCompro)) {{($SetMasterCompro == true) ? 'menu-open' : '' }} @endif {{ Request::is('MasterCompro/*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link SizeText active">
              <i class="nav-icon fas fa-user-tag"></i>

              <p>ระบบลูกหนี้ประนอมหนี้ <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview" style="margin-left: 15px;">
              <!-- <li class="nav-item">
                <a href="{{ route('MasterCompro.index') }}?type={{1}}" class="nav-link SizeText @if(isset($SetCompro1)) {{($SetCompro1 == true) ? 'active' : '' }} @endif">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>ประเภทประนอมหนี้</p>
                </a>
              </li> -->
              <li class="nav-item">
                <a href="{{ route('MasterCompro.index') }}?type={{2}}" class="nav-link SizeText @if(isset($SetCompro2)) {{($SetCompro2 == true) ? 'active' : '' }} @endif">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>ลูกหนี้ประนอมใหม่</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('MasterCompro.index') }}?type={{3}}" class="nav-link SizeText @if(isset($SetCompro3)) {{($SetCompro3 == true) ? 'active' : '' }} @endif">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>ลูกหนี้ประนอมเก่า</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('MasterCompro.index') }}?type={{5}}" class="nav-link SizeText @if(isset($SetCompro5)) {{($SetCompro5 == true) ? 'active' : '' }} @endif">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>รายการติดตามลูกหนี้</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('MasterCompro.index') }}?type={{6}}" class="nav-link SizeText @if(isset($SetCompro6)) {{($SetCompro6 == true) ? 'active' : '' }} @endif">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>รายการรับชำระค่างวด</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('MasterCompro.index') }}?type={{4}}" class="nav-link SizeText @if(isset($SetCompro4)) {{($SetCompro4 == true) ? 'active' : '' }} @endif">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>แจ้งเตือนขาดชำระลูกหนี้</p>
                </a>
              </li>
            </ul>
          </li>
        @endif
        
        @if(auth::user()->type == "แผนก การเงินนอก")
          <li class="nav-item has-treeview @if(isset($SetMasterCompro)) {{($SetMasterCompro == true) ? 'menu-open' : '' }} @endif {{ Request::is('MasterCompro/*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link SizeText active">
              <i class="nav-icon fas fa-user-tag"></i>

              <p>ระบบลูกหนี้ประนอมหนี้ <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview" style="margin-left: 15px;">
              <!-- <li class="nav-item">
                <a href="{{ route('MasterCompro.index') }}?type={{1}}" class="nav-link SizeText @if(isset($SetCompro1)) {{($SetCompro1 == true) ? 'active' : '' }} @endif">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>ประเภทประนอมหนี้</p>
                </a>
              </li> -->
              <li class="nav-item">
                <a href="{{ route('MasterCompro.index') }}?type={{2}}" class="nav-link SizeText @if(isset($SetCompro2)) {{($SetCompro2 == true) ? 'active' : '' }} @endif">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>ลูกหนี้ประนอมใหม่</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('MasterCompro.index') }}?type={{3}}" class="nav-link SizeText @if(isset($SetCompro3)) {{($SetCompro3 == true) ? 'active' : '' }} @endif">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>ลูกหนี้ประนอมเก่า</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('MasterCompro.index') }}?type={{5}}" class="nav-link SizeText @if(isset($SetCompro5)) {{($SetCompro5 == true) ? 'active' : '' }} @endif">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>รายการติดตามลูกหนี้</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('MasterCompro.index') }}?type={{6}}" class="nav-link SizeText @if(isset($SetCompro6)) {{($SetCompro6 == true) ? 'active' : '' }} @endif">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>รายการรับชำระค่างวด</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('MasterCompro.index') }}?type={{4}}" class="nav-link SizeText @if(isset($SetCompro4)) {{($SetCompro4 == true) ? 'active' : '' }} @endif">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>แจ้งเตือนขาดชำระลูกหนี้</p>
                </a>
              </li>
            </ul>
          </li>
        @endif
        
        @if(auth::user()->type == "Admin" or auth::user()->type == "แผนก วิเคราะห์" or auth::user()->type == "แผนก การเงินใน")
          <li class="nav-header">Finance Department</li>
          <li class="nav-item has-treeview @if(isset($SetMasterTreasury)) {{($SetMasterTreasury == true) ? 'menu-open' : '' }} @endif {{ Request::is('MasterTreasury/*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link active">
              <i class="nav-icon fa fa-gg-circle"></i>
              <p>
                แผนกการเงิน
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>

              <ul class="nav nav-treeview" style="margin-left: 15px;">
                <li class="nav-item">
                    <a href="{{ route('MasterTreasury.index') }}?type={{1}}" class="nav-link SizeText @if(isset($SetTreasuryActive1)) {{($SetTreasuryActive1 == true) ? 'active' : '' }} @endif">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>รายการขอเบิกเงิน</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('MasterTreasury.index') }}?type={{2}}" class="nav-link SizeText @if(isset($SetTreasuryActive2)) {{($SetTreasuryActive2 == true) ? 'active' : '' }} @endif">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>รายการขอเบิกสำรองจ่าย</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('MasterTreasury.index') }}?type={{3}}" class="nav-link SizeText @if(isset($SetTreasuryActive3)) {{($SetTreasuryActive3 == true) ? 'active' : '' }} @endif">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>รายการขอเบิกค่าของกลาง</p>
                    </a>
                </li>
              </ul>
          </li>
        @endif

          <li class="nav-header">Documentation</li>
          <li class="nav-item has-treeview">
            <a href="{{ route('MasterDocument.index') }}?type={{1}}" class="nav-link SizeText active bg-primary">
              <i class="nav-icon fas fa-archive"></i>
              <p>
                Data Warehouse
              </p>
            </a>
          </li>

        </ul>
      </nav>
    </div>
  </aside>

  <!-- Pop up  -->
  <div class="modal fade" id="modal-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-body">
        </div>
        <div class="modal-footer justify-content-between">
        </div>
      </div>
    </div>
  </div>

  <!-- {{-- Popup --}} -->
  <script>
    $(function () {
      $("#modal-1").on("show.bs.modal", function (e) {
        var link = $(e.relatedTarget).data("link");
        $("#modal-1 .modal-body").load(link, function(){
        });
      });
    });
  </script>

  <!-- {{-- แจ้งเตือนอนุมัติ แผนกการเงิน --}} -->
  <!-- <script type="text/javascript">
    SearchData(); //เรียกใช้งานทันที
    var Data = setInterval(() => {SearchData()}, 10000);

    function SearchData(){ 
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
        url:"{{ route('SearchData', [3, 0]) }}",
        method:"GET",
        data:{},
    
        success:function(result){ //เสร็จแล้วทำอะไรต่อ
          $('#ShowData').html(result);
        }
      });
    };
  </script> -->
