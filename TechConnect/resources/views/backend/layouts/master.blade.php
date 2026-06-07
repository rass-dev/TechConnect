<!DOCTYPE html>
<html lang="en">

@include('backend.layouts.head')

<body id="page-top">

  <div class="tc-sidebar-backdrop" aria-hidden="true"></div>

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    @include('backend.layouts.sidebar')
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        @include('backend.layouts.header')
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="tc-admin-content">
          @include('backend.layouts.notification')
          @yield('main-content')
        </div>

      </div>
      <!-- End of Main Content -->
      @include('backend.layouts.footer')

</body>

</html>
