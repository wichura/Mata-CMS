MATA CMS
====

Mata CMS - generic framework for project-driven web applications


Mata installation
================= 

This section describes how to install Mata in your existing Yii Project: 

- clone Mata to the root of your project by issuing the command

```
git clone --recursive https://github.com/wichura/Mata-CMS.git Mata-CMS
```

- execute in Terminal:

```
cd Mata-CMS/mata && php yiic mata install
```

- Follow the steps in the installation


- make sure Yii creates a mata application by adding the following to the top of index.php: 

```
$application = dirname(__FILE__) . "/mata/components/MataWebApplication.php";
```

and replacing the last line with: 

```
require_once($mata);
Yii::createApplication("MataWebApplication", $config)->run();
```

-- You're done!