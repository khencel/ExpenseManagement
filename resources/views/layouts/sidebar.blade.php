<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item">
        <a href="/home" class="nav-link {{request()->is('home')?'active':''}}">
          <i class="nav-icon fas fa-th"></i>
          <p>
            Dashboard
          </p>
        </a>
      </li>
      @role('Administrator')
      <li class="nav-item menu-open">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-tachometer-alt"></i>
          <p>
            User Management
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item ">
            <a href="{{ asset('role/index') }}" class="nav-link {{request()->is('role/index')?'active':''}}">
              <i class="far fa-circle nav-icon"></i>
              <p>Roles</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ asset('user/index') }}" class="nav-link {{request()->is('user/index')?'active':''}}">
              <i class="far fa-circle nav-icon"></i>
              <p>Users</p>
            </a>
          </li>
        </ul>
      </li>
      @endrole
      <li class="nav-item menu-open">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-tachometer-alt"></i>
          <p>
            Expense Management
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          @role('Administrator')
          <li class="nav-item">
            <a href="{{ asset('category/index') }}" class="nav-link {{request()->is('category/index')?'active':''}}">
              <i class="far fa-circle nav-icon"></i>
              <p>Expense Categories</p>
            </a>
          </li>
          @endrole
          <li class="nav-item">
            <a href="{{ asset('expense/index') }}" class="nav-link {{request()->is('expense/index')?'active':''}}">
              <i class="far fa-circle nav-icon"></i>
              <p>Expenses</p>
            </a>
          </li>
        </ul>
      </li>
      
    </ul>
</nav>