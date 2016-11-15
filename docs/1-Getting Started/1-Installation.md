# Installation

- [Using the Installer](#using-installer)
- [Composer](#composer)
    - [Create Project](#create-project)
    - [Just Core](#just-core)
- [Cloning the Repository](#cloning-repository)

<a name="using-installer"></a>
## Using the Installer
`composer global require "jumpgate/installer=~1.0"`

`jumpgate new <directory>`

> You can use the ``--slim`` option at the end to get a minimal version.

The full version comes with JumpGate core, menu and users.  The slim variant comes with only core and menu.

<a name="composer"></a>
## Composer
<a name="create-project"></a>
### Create Project
`composer create-project jumpgate/jumpgate <path>`

Using JumpGate it will pull in Core and Menu automatically.

<a name="just-core"></a>
### Just Core
`composer require jumpgate/core:~1.0`

<a name="cloning-repository"></a>
## Cloning the Repository
`git clone git@github.com:JumpGate/JumpGate.git ./`
