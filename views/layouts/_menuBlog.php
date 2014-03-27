<?php
/**
 * Return a list of menu item suitable for display in the main Nav
 */
return [
	['label' => 'Blog', 'url' => '#', 'items' => [
			['label' => 'Entries', 'url' => ['/blog/default/index'], 'items' =>[
				['label' => 'New Entry', 'url' => ['/blog/blog/create']],
			]],
			['label' => 'Categories', 'url' => ['/blog/category/index']]
		]
	],
];