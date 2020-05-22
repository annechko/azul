#!/usr/bin/env php
<?php

$finder = PhpCsFixer\Finder::create()
	->in([
		'.' . DIRECTORY_SEPARATOR . 'src',
		'.' . DIRECTORY_SEPARATOR . 'tests',
	]);

return PhpCsFixer\Config::create()
	->setCacheFile('.' . DIRECTORY_SEPARATOR . '.php_cs.cache')
	->setRules(
		[
			'@Symfony' => true,
			'@PHP73Migration' => true,
			'no_multiline_whitespace_around_double_arrow' => null,
			'no_superfluous_phpdoc_tags' => null, // look for options
			'no_blank_lines_after_class_opening' => true,
			'yoda_style' => null,
			'concat_space' => ['spacing' => 'one'], // '' . ''
			'blank_line_before_statement' => null,
			'phpdoc_inline_tag' => true,
			'phpdoc_align' => false,
			'phpdoc_separation' => false,
			'phpdoc_annotation_without_dot' => false,
			'single_line_throw' => false,
			'increment_style' => false,
			'phpdoc_summary' => null,
			'class_definition' => [
				'single_item_single_line' => true,
			],
			'phpdoc_no_alias_tag' => [
				'type' => 'var',
				'link' => 'see',
			],
			'no_extra_blank_lines' => true,
			'no_whitespace_in_blank_line' => true,
			'braces' => true,
			'no_unused_imports' => true,
			'ordered_imports' => true,
			'new_with_braces' => true,
			'single_blank_line_at_eof' => false,
			'single_line_comment_style' => [
				'comment_types' => ['asterisk'],
			],
		]
	)
	->setIndent("\t")
	->setFinder($finder);
