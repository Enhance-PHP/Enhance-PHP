Enhance PHP [![Build Status](https://secure.travis-ci.org/kinncj/Enhance-PHP.png)](http://travis-ci.org/kinncj/Enhance-PHP)

A unit testing framework with mocks and stubs. Built for PHP, in PHP!

Licensed under the Apache License, Version 2.0 (the "License"); you may not use this file except in compliance with the License. You may obtain a copy of the License at http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software distributed under the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the License for the specific language governing permissions and limitations under the License.

http://www.enhance-php.com/
https://github.com/Enhance-PHP/Enhance-PHP

v2.1.3 (In Progress)
TextPtBr - Brazilian Portuguese translation.

v2.1.2
Line numbers for errors
Type assertions
Code coverage fix (for constructors)
* Big thanks to Lewis Wright for these contributions

v2.1.1
TAP Template output
CLI exit codes

v2.1.0
PHP namespaces added - usage updated. View the documentation on our website: http://www.enhance-php.com/
Sample:
\Enhance\Core::runTests();

________________________________________________________________

Important Note, version 2.1.0 onwards requires PHP 5.3 or above.
Please use version 2.0.2 for older versions of PHP 5.
________________________________________________________________

v2.0.2
When running from command line (for example within you IDE) the message "Test Passed" or "Test Failed" appears both top and bottom of the result set.
See issue #1 - hidden files should be excluded from auto discovery on MAC OS.

v2.0.1
Improvements to auto-discovery to allow recursion to be specified and to allow directories to be excluded.

v2.0.0
Localisation and improvements to mocks. Minor bug fixes.

v1.9
Fixed auto-discovery to make it recursive, with the option for it not to be

v1.8
Fixed case sensitivity for setUp and tearDown methods as not everyone will follow normal PHP conventions

v1.7
Fixed auto-discovery bug

v1.6
Test scenarios code and tests

v1.5
Auto-detect code and tests

v1.4
EnhanceTestFixture base class to marking test classes

v1.3
Adjustments to meet PHP coding standards

v1.2
Output factory
Output template interface

v1.1
Command Line Output
XML Output

v1.0
First official release
Assertions
Mocks
Stubs
Method Coverage
HTML Output

