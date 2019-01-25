# vm_impl

## Folder structure:


* ./
  * conf
    * items.php 
    * money.php
  * impl_sample
    * change_list_impl.php	
    * customer_request_impl.php
    * item_list_impl.php
  * module
    * change_list.php
    * customer_request.php
    * item_list.php
    * vending_machine.php
  * test
    * test.php


## Folder Info:

### conf:
Constraint folder. could add different kinds of coins in this part, no need for ASC order in terms of value nor did items part. You can code the coin with any names and codes if you wish.

### impl_sample:
Simple implementation of interfaces in module folder. Users could simply modify the method inside to connect to memory or DB. To have a quick start, check those implementation files and see how to use it in test\test.php.

### module:
Core stateless module of the package, including 3 interfaces to help use the VM class.

### test:
Simple test with implementatin samples.

### Next stage:

Test + Bug shooting + Refactoring ~~
Waiting for judge.

What's more in the future:

DB/Memory/Plugin conn folder for users.
A better look of test.php

2019.1.25
