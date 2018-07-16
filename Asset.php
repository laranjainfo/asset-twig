<?php

namespace Laranjainfo\TwigExtension;

use Twig\TwigFunction;

class Asset extends \Slim\Views\TwigExtension
{
	public $cfg;

	public function __construct($cfg)
	{
		$this->cfg = $config ? $config : require __DIR__ . '/app/config/asset.php';
	}

	// Registering
	public function getFunctions()
	{
		return array(
			new TwigFunction('asset', [$this, 'SimpleAsset'], ['is_safe' => ['html']]),
			new TwigFunction('_a', [$this, 'SimpleAsset'], ['is_safe' => ['html']])
		);
	}

	/**
	 * Generating assets
	 * 
	 * @param  string|array $file    String of array with file configurations
	 * @param  string|null	$type    String with file type
	 * @param  bool 		$version Show version? true to get package.json version, false to hide, string to print
	 * @return string
	 */
	public function SimpleAsset($file, $type = null, $version = true, $params = null)
	{
		$data = [
			'file'		=> $this->filter($file, $file, 'file'),
			'type' 		=> $this->filter($file, $type, 'type'),
			'version'	=> $this->filter($file, $version, 'version'),
			'params'	=> $this->filter($file, $params, 'params'),
		];

		// $file exists?
		if ($data['file'] == null)
		{
			exit('The use of "file" variable in "asset" is required');
		}

		// Skip or go through?
		if ($data['type'] !== null)
		{
			return $this->AssetRender($data);
		}
		else
		{
			// Verificar extensão do arquivo
			if (strpos($data['file'], '.') !== false)
			{
				$nFile			= explode('.', $data['file']);
				$data['type']	= end($nFile);
			}

			// Encontrar o formato do arquivo
			return $this->AssetRender($data);
		}
	}

	/**
	 * Converting asset line
	 * 
	 * @param  array $data Array of configuration
	 * @return string
	 */
	public function AssetRender($data)
	{
		$file		= $data['file'];
		$type		= $data['type'];
		$version	= $this->cfg['version'] == true ? (isset($data['version']) ? $data['version'] : null) : false;

		// File extension required
		if ($type == false OR $type == null)
		{
			return false;
		}

		// Extensions
		$types = [
			'css'		 => '<link rel="stylesheet" type="text/css" href="'.$this->cfg['css_dir'].'{{ asset }}">',
			'js'		 => '<script type="text/javascript" src="'.$this->cfg['js_dir'].'{{ asset }}"></script>',
			'images'	 => '<img src="'.$this->cfg['images_dir'].'{{ asset }}" {{ params }}>',
			'manifest'	 => '<link rel="manifest" href="'.$this->cfg['manifest_dir'].'{{ asset }}">',
			'touch-icon' => '<link rel="apple-touch-icon" href="'.$this->cfg['touch_icon_dir'].'{{ asset }}">',
		];

		// Version
		if ($version == null)
		{
			$v = null;
		}
		elseif ($version == true)
		{
			$v = $this->cfg['version_perfix'] . $this->cfg['version'];
		}
		else
		{
			$v = $this->cfg['version_perfix'] . $version;
		}

		// Print version of file inside file
		$asset = $file . $v;

		// There are extra params??
		$params = function()
		{
			if (isset($data['params']) && $data['params'] !== null && $data['params'] !== false)
			{
				$params = $data['params'];

				if (is_array($params))
				{
					foreach ($params as $k => $v)
					{
						$return[] = $k.'="'.$v.'"';
					}

					return implode(' ', $return);
				}

				return $params;
			}

			return null;
		};

		// Defining and returning the string
		foreach ($types as $k => $i)
		{
			if ($k == $type)
			{
				return str_replace('{{ asset }}',  $asset,  $i);
				return str_replace('{{ params }}', $params, $i);
			}
		}

		// WOOOOT
		return false;
	}

	/**
	 * Finding parameters
	 * 
	 * @param  string|array $array First element/array
	 * @param  string 		$item  Item
	 * @param  string		$param Parameter
	 * @return string
	 */
	protected function filter($array, $item, $param)
	{
		if (is_array($array))
		{
			if (isset($array[$param]))
			{
				return $array[$param];
			}
		}
		else
		{
			return isset($item) ? $item : null;
		}

		return null;
	}
}