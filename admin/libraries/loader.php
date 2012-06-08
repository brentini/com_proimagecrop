<?php
/**
 * @package		Pro Image Crop
 * @subpackage	com_proimagecrop
 * @copyright	Copyright (C) AtomTech, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die();

if (!defined('DS'))
{
	define('DS', DIRECTORY_SEPARATOR);
}

spl_autoload_register(array('JLoader', 'load'));

class ProImageCropLoader extends JLoader
{

	protected static $paths = array();

	protected static $classes = array();

	public static function import($filePath, $base = null, $key = 'libraries.')
	{
		$keyPath = $key ? $key . $filePath : $filePath;
		if (!isset($paths[$keyPath]))
		{
			if (!$base)
			{ //$base =  JPATH_ADMINISTRATOR.DS.'components'.DS.'com_proimagecrop'.DS.'libraries';
				$base = JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_proimagecrop' . DS . 'libraries';
			}
			
			$parts = explode('.', $filePath);
			
			$className = array_pop($parts);
			
			switch ($className)
			{
				case 'helper':
					$className = ucfirst(array_pop($parts)) . ucfirst($className);
					break;
				Default:
					$className = ucfirst($className);
					break;
			}
			
			$path = str_replace('.', DS, $filePath);
			
			if (strpos($filePath, 'format') === 0)
			{ //$className	= 'ProImageCrop'.$className;
				$className = 'Format' . $className;
				$classes = JLoader::register($className, $base . DS . $path . '.php');
				$rs = isset($classes[strtolower($className)]);
			}
			else
			{
				$filename = $base . DS . $path . '.php';
				if (is_file($filename))
				{
					$rs = (bool) include $filename;
				}
				else
				{ // if the file doesn't exist fail
					$rs = false;
				}
			}
			ProImageCropLoader::$paths[$keyPath] = $rs;
		}
		
		return ProImageCropLoader::$paths[$keyPath];
	}
}

function ProImageCropImport($path)
{
	return ProImageCropLoader::import($path);
}
