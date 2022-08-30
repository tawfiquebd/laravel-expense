<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard.index') }}" class="brand-link text-center">
        <span class="brand-text font-weight-light">Expense Manager</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('dashboard.index') }}" class="nav-link">
                        <i class="fa fa-tachometer nav-icon"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('category.index') }}" class="nav-link">
                        <i class="fa fa-tachometer nav-icon"></i>
                        <p>Category</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('books.index') }}" class="nav-link">
                        <i class="fa fa-tachometer nav-icon"></i>
                        <p>Expense</p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="fa fa-area-chart nav-icon"></i>
                        <p>Reports <i class="right fa fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('report.daily') }}" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>Daily</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('report.weekly') }}" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>Weekly</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('report.monthly') }}" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>Monthly</p>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
