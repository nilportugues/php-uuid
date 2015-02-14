[![Build Status](https://travis-ci.org/nilportugues/uuid.png)](https://travis-ci.org/nilportugues/uuid) [![Coverage Status](https://img.shields.io/coveralls/nilportugues/uuid.svg)](https://coveralls.io/r/nilportugues/uuid) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/nilportugues/uuid/badges/quality-score.png)](https://scrutinizer-ci.com/g/nilportugues/uuid/) [![Latest Stable Version](https://poser.pugx.org/nilportugues/uuid/v/stable.svg)](https://packagist.org/packages/nilportugues/uuid) [![Total Downloads](https://poser.pugx.org/nilportugues/uuid/downloads.svg)](https://packagist.org/packages/nilportugues/uuid) [![License](https://poser.pugx.org/nilportugues/uuid/license.svg)](https://packagist.org/packages/nilportugues/uuid) [![SensioLabsInsight](https://insight.sensiolabs.com/projects/ee408e0a-5d08-42ce-9f42-b7a5220b1048/mini.png)](https://insight.sensiolabs.com/projects/ee408e0a-5d08-42ce-9f42-b7a5220b1048)


#Uuid Generator
This class' intent is to encapsulate Uuid's latest and more secure versions removing the need to explicitly hard-code a Uuid version everywhere.

## Uuid versions
Currently Uuid has 5 versions and while all of them are valid, usage of newest versions is always preferred. Lastest preferred versions are:

- Uuid4 preferred over Uuid1.
- Uuid5 preferred over Uuid3 and Uuid1

## Usage

Usage is real simple, you can create your Uuid right away or under certain namespaces.

### Without namespacing
This is the most common case. Usage is straight-forward:

```php
<?php
use NilPortugues\Uuid\Uuid;

echo Uuid::create(); // "13dfa123-d7a6-4082-8b3f-513c28f5d691"
```

### With namespacing
First of all, the following namespaces exists:

- DNS Namespace
- URL Namespace
- OID (Object Id) Namespace
- X500 Namespace

Code-wise it's use can be defined using a constant.

```php
<?php
use NilPortugues\Uuid\Uuid;

echo Uuid::create(Uuid::NAMESPACE_DNS, 'nilportugues.com');

echo Uuid::create(Uuid::NAMESPACE_URL, 'http://nilportugues.com/robots.txt');

echo Uuid::create(Uuid::NAMESPACE_OID, 'Foo\Bar');

echo Uuid::create(Uuid::NAMESPACE_X500, '/c=us/o=Sun/ou=People/cn=Rosanna Lee');
```

More on its usage can be found here: http://tools.ietf.org/html/rfc4122#appendix-C



