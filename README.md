# vm_impl

folder structure:

.

├── conf

│   ├── items.php 

│   └── money.php

├── impl_sample

│   ├── change_list_impl.php

│   ├── customer_request_impl.php

│   └── item_list_impl.php

├── module

│   ├── change_list.php

│   ├── customer_request.php

│   ├── item_list.php

│   └── vending_machine.php

└── test

    └── test.php
    

Folder Info:

conf:
Constant folder. could add different kinds of money in this part, no need for ASC order in terms of value nor did items part.

impl_sample:
simple implementation of interfaces in module folder. Users could simply modify the method inside to connect to memory or DB

module:
Core stateless module of the package, including 3 interfaces to help use the VM class.

test:
Simple test with implementatin samples.

Next stage:

Test + Bug shooting + Refactoring

2019.1.25
