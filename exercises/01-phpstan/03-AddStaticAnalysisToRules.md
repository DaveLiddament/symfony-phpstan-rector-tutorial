# Add static analysis to rules

Just like your production and test code, PHPStan should be run on your custom rules, and the tests for them.


#### Update PHPStan config

Update paths section of `phpstan.neon`

```yaml
    paths:
    - src
    - tests
    - utils/Phpstan
    excludePaths:
    - utils/Phpstan/*/Fixtures/*
```

#### Run PHPStan

```bash
vendor/bin/phpstan analyse
```


Issues found for the `DontCallPrintRule` and the corresponding test:

```
 ------ ------------------------------------------------------------------------------------------------------------------------------ 
  Line   utils/Phpstan/Rules/DontCallPrintRule.php                                                                                     
 ------ ------------------------------------------------------------------------------------------------------------------------------ 
  12     Class Utils\Phpstan\Rules\DontCallPrintRule implements generic interface PHPStan\Rules\Rule but does  
         not specify its types: TNodeType                                                                                              
         💡 You can turn this off by setting checkGenericClassInNonGenericObjectType: false in your                                    
         phpstan.neon.                                                                                                                 
 ------ ------------------------------------------------------------------------------------------------------------------------------ 

 ------ ------------------------------------------------------------------------------------------------------------------------ 
  Line   utils/Phpstan/Tests/DontCallGotoRule/DontCallPrintRuleTest.php                                                          
 ------ ------------------------------------------------------------------------------------------------------------------------ 
  11     Class Utils\Phpstan\Tests\DontCallPrintRule\DontCallPrintRuleTest extends generic class         
         PHPStan\Testing\RuleTestCase but does not specify its types: TRule                                                      
         💡 You can turn this off by setting checkGenericClassInNonGenericObjectType: false in your                              
         phpstan.neon.                                                                                                           
  13     Method Utils\Phpstan\Tests\DontCallPrintRule\DontCallPrintRuleTest::getRule() return type with  
         generic interface PHPStan\Rules\Rule does not specify its types: TNodeType                                              
         💡 You can turn this off by setting checkGenericClassInNonGenericObjectType: false in your                              
         phpstan.neon.                                                                                                           
 ------ ------------------------------------------------------------------------------------------------------------------------ 
```

### Fix issues

Delete the initial `src/Phpstan/print.php` file now that is covered by tests.


Update `utils/Phpstan/Rules/DontCallPrintRule.php`:

```php
/** @implements Rule<Node\Expr\Print_> */
class DontCallPrintRule implements Rule
```

And `utils/Phpstan/Tests/DontCallGotoRule/DontCallPrintRuleTest.php`:

```php
/** @extends RuleTestCase<DontCallPrintRule> */
class DontCallPrintRuleTest extends RuleTestCase
```



## Your turn

Run PHPStan and fix all issues it finds. 
