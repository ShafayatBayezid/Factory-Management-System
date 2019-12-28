<?php

echo "

  <div id='wrapper' class='animate'>
    <nav class='navbar header-top fixed-top navbar-expand-lg  navbar-light bg-light'>
      <span class='navbar-toggler-icon leftmenutrigger'></span>
      Admin Panel
      <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarText' aria-controls='navbarText'
        aria-expanded='false' aria-label='Toggle navigation'>
        <span class='navbar-toggler-icon'></span>
      </button>      
        
        <ul class='navbar-nav animate side-nav'>
          <li class='nav-item pl-3'>
            <h6><a class='nav-link' href='index.php'>Home</a></h6>
              <span class='sr-only'>(current)</span>
            </a>
          </li>
          <li class='nav-item pl-3 pt-4'>
            <h6><a class='dissable px-2' style='color: black;'>PRODUCTS</a></h6>
          </li>
          <li class='nav-item pl-3'>
            <h6><a class='nav-link' href='manageProducts.php'>Manage Products</a></h6>
          </li>
          <li class='nav-item pl-3'>
            <h6><a class='nav-link' href='dailyRecords.php'>Daily Records</a></h6>
          </li>
          <li class='nav-item pl-3 pt-4'>
            <h6><a class='dissable px-2' style='color: black;'>DEALERS</a></h6>
          </li>
          <li class='nav-item pl-3'>
            <h6><a class='nav-link' href='manageDealers.php'>Manage Dealers</a></h6>
          </li>
          <li class='nav-item pl-3'>
            <h6><a class='nav-link' href='manageInvoice.php'>Manage Invoices</a></h6>
          </li>
          <li class='nav-item pl-3'>
            <h6><a class='nav-link text-green font-weight-bold' href='https://github.com/Androlation/Factory-Management-System'>Get On GitHub</a></h6>
          </li>
          
        </ul>
    </nav>
    
  </div>
  
";

?>
