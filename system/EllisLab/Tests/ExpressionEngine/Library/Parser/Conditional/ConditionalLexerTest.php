<?php

namespace EllisLab\Tests\ExpressionEngine\Library\Parser\Conditional;

use EllisLab\ExpressionEngine\Library\Parser\Conditional\ConditionalLexer;

class ConditionalLexerTest extends \PHPUnit_Framework_TestCase {

	protected $valueTypes = array(
		'bool'				=> array('token' => array('BOOL', 'TRUE'),							'value' => 'TRUE'),
		'int'				=> array('token' => array('NUMBER', '5'),							'value' => '5'),
		'negative'			=> array('token' => array('NUMBER', '-5'),							'value' => '-5'),
		'bigfloat'			=> array('token' => array('NUMBER', '5.1'),							'value' => '5.1'),
		'littlefloat'		=> array('token' => array('NUMBER', '.1'),							'value' => '.1'),
		'string'			=> array('token' => array('STRING', 'string'),						'value' => '"string"'),
		'dash-string'		=> array('token' => array('STRING', 'dash-string'),					'value' => '"dash-string"'),
		'dot.string'		=> array('token' => array('STRING', 'dot.string'),					'value' => '"dot.string"'),
		'intstring'			=> array('token' => array('STRING', '5'),							'value' => '"5"'),
		'variable'			=> array('token' => array('VARIABLE', 'variable'),					'value' => 'variable'),
		'dash-variable'		=> array('token' => array('VARIABLE', 'dash-variable'),				'value' => 'dash-variable'),
		'simpletag'			=> array('token' => array('TAG', '{simpletag}'),					'value' => '{simpletag}'),
		'moduletag'			=> array('token' => array('TAG', '{exp:foo:bar}'),					'value' => '{exp:foo:bar}'),
		'tag_with_params'	=> array('token' => array('TAG', '{exp:foo:bar param="value"}'),	'value' => '{exp:foo:bar param="value"}')
	);

	protected $commonTokens = array(
		'start' => array(
			array('IF', '{if ')
		),
		'end'   => array(
			array('ENDCOND',			'}'),
			array('TEMPLATE_STRING',	'out'),
			array('ENDIF',				'{/if}'),
			array('EOS',				TRUE)
		)
	);

	public function setUp()
	{
		$this->lexer = new ConditionalLexer();
	}

	public function tearDown()
	{
		$this->lexer = NULL;
	}

	protected function runLexer($description, $str_in, $expected)
	{
		$result = $this->lexer->tokenize($str_in);
		$this->assertSame($expected, $result, $description);
	}

	/**
	 * @dataProvider goodDataProvider
	 */
	public function testGoodDataProvider($description, $str_in, $expected)
	{
		$this->runLexer($description, $str_in, $expected);
	}

	/**
	 * @dataProvider badDataProvider
	 */
	public function testBadDataProvider($description, $str_in, $code)
	{
		$this->setExpectedException('EllisLab\ExpressionEngine\Library\Parser\Conditional\Exception\ConditionalLexerException', $code);
		$this->lexer->tokenize($str_in);
	}

	protected function assembleCommonCondition($expression)
	{
		return "{if ".$expression."}out{/if}";
	}

	protected function assembleCommonTokens($tokens)
	{
		return array_merge(
			$this->commonTokens['start'],
			$tokens,
			$this->commonTokens['end']
		);
	}

	public function goodDataProvider()
	{
		// assemble all of the tests
		return array_merge(
			array(),

			// Individual Tokens
			$this->validNumberTokens(),
			$this->validVariableTokens(),

			// Operators
			$this->validOperatorsWithSpaces(),
			$this->validOperatorsWithoutSpaces(),
			$this->invalidOperatorsWithSpaces(),
			$this->invalidOperatorsWithoutSpaces(),
			$this->edgyInvalidOperatorsWithoutSpaces(),
			$this->edgyDoubleDashWithoutSpaces(),

			array() // non trailing comma thing for covienence
		);
	}

	public function badDataProvider()
	{
		return array(
			array('Unclosed String (single quotes)',	"{if string == 'ee}out{/if}", 30),
			array('Unclosed String (double quotes)',	'{if string == "ee}out{/if}', 30),
			array('Unclosed Conditional', 				'{if string == "ee"}out', 21),
			array('Unterminated Conditional', 			'{if string == "ee"out{/if}', 30),
			array('If as a Prefix', 					'{if:foo}', 20),
			array('Ifelse duplicity', 					'{if 5 == 5}out{if:else:else}out{/if}', 20),
			array('Ifelse Prefixing', 					'{if 5 == 5}out{if:elsebeth}out{/if}', 20),
			array('Ifelseif Prefixing', 				'{if 5 == 5}out{if:elseiffy}out{/if}', 20),
			array('NUMBER + :', 						'{if 1:2}out{/if}', 10),
			array('OK + :',	 							'{if :foo}out{/if}', 10),
			array('OK + :',	 							'{if "foo":bar}out{/if}', 10),
			array('OK + :',	 							"{if 'foo':bar}out{/if}", 10),
			array('FLOAT + .', 							'{if 1.2.3}out{/if}', 10),
			array('FLOAT + :', 							'{if 1.2:3}out{/if}', 10),
		);
	}

	protected function validOperatorsWithSpaces()
	{
		$return = array();

		$operators = array(
			'||', '&&', '**',
			'==', '!=', '<=', '>=', '<>', '<', '>',
			'%', '+', '-', '*', '/',
			'.', '!', '^'
		);

		// Test each operator (duh)
		foreach ($operators as $operator)
		{
			// Testing our common value types for edge-cases.
			// We don't need to care about permutations here just combinations
			// because we need to ensure that these value types are found
			// on both sides of an operator.
			foreach ($this->valueTypes as $type => $value)
			{
				$expected = array(
					$value['token'],
					array('WHITESPACE',	' '),
					array('OPERATOR',	$operator),
					array('WHITESPACE',	' '),
					$value['token']
				);

				$return[] = array(
					"The \"{$operator}\" operator with {$type} values",
					$this->assembleCommonCondition($value['value']." ".$operator." ".$value['value']),
					$this->assembleCommonTokens($expected)
				);
			}
		}

		return $return;
	}

	// Things change without spaces around the operator
	protected function validOperatorsWithoutSpaces()
	{
		$return = array();

		$operators = array(
			'||', '&&', '**',
			'==', '!=', '<=', '>=', '<>', '<', '>',
			'%', '+', '-', '*', '/',
			'.', '!', '^'
		);

		// Test each operator (duh)
		foreach ($operators as $operator)
		{
			// Testing our common value types for edge-cases.
			// We don't need to care about permutations here just combinations
			// because we need to ensure that these value types are found
			// on both sides of an operator.
			foreach ($this->valueTypes as $type => $value)
			{
				// Some exceptions for exceptional operators
				if ($operator == '-')
				{
					if ($type == 'bool' || $type == 'variable' || $type == 'dash-variable')
					{
						continue;
					}
				}
				elseif ($operator == '.')
				{
					if ($type == 'int' || $type == 'bigfloat' || $type == 'littlefloat')
					{
						continue;
					}
				}

				$expected = array(
					$value['token'],
					array('OPERATOR', $operator),
					$value['token']
				);

				$return[] = array(
					"The \"{$operator}\" operator with {$type} values (no spaces)",
					$this->assembleCommonCondition($value['value'].$operator.$value['value']),
					$this->assembleCommonTokens($expected)
				);
			}
		}

		// Manual tests for the '.' operator's exceptions
		$operator = '.';

		// int.int -> NUMBER
		$value = $this->valueTypes['int']['value'];
		$expected = array(
			array('NUMBER',	$value.'.'.$value)
		);
		$return[] = array(
			"The \"{$operator}\" operator with int values (no spaces)",
			$this->assembleCommonCondition($value.$operator.$value),
			$this->assembleCommonTokens($expected)
		);

		// int.negative -> OPERATOR
		$int = $this->valueTypes['int'];
		$negative = $this->valueTypes['negative'];
		$expected = array(
			$int['token'],
			array('OPERATOR', '.'),
			$negative['token'],
		);
		$return[] = array(
			"The \"{$operator}\" operator with int and negative values (no spaces)",
			$this->assembleCommonCondition($int['value'].$operator.$negative['value']),
			$this->assembleCommonTokens($expected)
		);

		// negative.int -> NUMBER
		$int = $this->valueTypes['int'];
		$negative = $this->valueTypes['negative'];
		$expected = array(
			array('NUMBER',	$negative['value'].'.'.$int['value'])
		);
		$return[] = array(
			"The \"{$operator}\" operator with int and negative values (no spaces)",
			$this->assembleCommonCondition($negative['value'].$operator.$int['value']),
			$this->assembleCommonTokens($expected)
		);

		// *float.* -> EXCEPTION (this is covered in our exceptions test)

		// Manual tests for the '-' operator's exceptions
		$operator = '-';

		// bool-bool -> variable
		// variable-variable -> variable
		// dash-variable-dash-variable -> variable
		foreach (array('bool', 'variable', 'dash-variable') as $type)
		{
			$value = $this->valueTypes[$type]['value'];
			$expected = array(
				array('VARIABLE', $value.'-'.$value)
			);
			$return[] = array(
				"The \"{$operator}\" operator with {$type} values (no spaces)",
				$this->assembleCommonCondition($value.$operator.$value),
				$this->assembleCommonTokens($expected)
			);
		}

		return $return;
	}

	protected function invalidOperatorsWithSpaces()
	{
		$return = array();

		$valid_operators = array(
			'||', '&&', '**',
			'==', '!=', '<=', '>=', '<>', '<', '>',
			'%', '+', '-', '*', '/',
			'.', '!', '^'
		);

		// Manual invalid operator assignments
		$invalid_operators = array(
			'===', '!=='
		);

		// Build out some combinations
		foreach ($valid_operators as $first)
		{
			foreach ($valid_operators as $second)
			{
				$operator = $first.$second;

				if (in_array($operator, $valid_operators))
				{
					continue;
				}

				$invalid_operators[] = $operator;
			}
		}

		$invalid_operators = array_unique($invalid_operators);

		foreach ($invalid_operators as $operator)
		{
			foreach ($this->valueTypes as $type => $value)
			{
				$expected = array(
					$value['token'],
					array('WHITESPACE',	' '),
					array('MISC', $operator),
					array('WHITESPACE',	' '),
					$value['token']
				);

				$return[] = array(
					"The \"{$operator}\" operator with {$type} values",
					$this->assembleCommonCondition($value['value']." ".$operator." ".$value['value']),
					$this->assembleCommonTokens($expected)
				);
			}
		}

		return $return;
	}

	// Things change without spaces around the operator
	protected function invalidOperatorsWithoutSpaces()
	{
		$return = array();

		$valid_operators = array(
			'||', '&&', '**',
			'==', '!=', '<=', '>=', '<>', '<', '>',
			'%', '+', '-', '*', '/',
			'.', '!', '^'
		);

		// Manual invalid operator assignments
		$invalid_operators = array(
			'===', '!=='
		);

		$edge_cases = array();

		// Build out some combinations
		foreach ($valid_operators as $first)
		{
			foreach ($valid_operators as $second)
			{
				$operator = $first.$second;

				if (in_array($operator, $valid_operators))
				{
					continue;
				}

				// We will handle this edge case by hand see: edgyDoubleDashWithoutSpaces()
				if ($operator == '--')
				{
					continue;
				}

				if ($second == '.' || $second == '-')
				{
					$edge_cases[] = $operator;
				}
				else
				{
					$invalid_operators[] = $operator;
				}
			}
		}

		$invalid_operators = array_unique($invalid_operators);
		$edge_cases = array_unique($edge_cases);

		foreach ($invalid_operators as $operator)
		{
			foreach ($this->valueTypes as $type => $value)
			{
				// Float followed by a period is an error state and throws an
				// exception.
				if ((strpos($type, 'float') !== FALSE) && (strpos($operator, '.') === 0))
				{
					continue;
				}

				$expected = array(
					$value['token'],
					array('MISC', $operator),
					$value['token']
				);

				$return[] = array(
					"The \"{$operator}\" operator with {$type} values (no spaces)",
					$this->assembleCommonCondition($value['value'].$operator.$value['value']),
					$this->assembleCommonTokens($expected)
				);
			}
		}

		// When a period or dash end an operator and the next character is
		// a digit then it's not an operator any longer
		foreach ($edge_cases as $operator)
		{
			foreach ($this->valueTypes as $type => $value)
			{
				// To avoid confusing code these will be done "by hand" see: edgyInvalidOperatorsWithoutSpaces()
				if ($value['token'][0] == 'NUMBER')
				{
					continue;
				}

				$expected = array(
					$value['token'],
					array('MISC', $operator),
					$value['token']
				);

				$return[] = array(
					"The \"{$operator}\" operator with {$type} values (no spaces)",
					$this->assembleCommonCondition($value['value'].$operator.$value['value']),
					$this->assembleCommonTokens($expected)
				);
			}
		}

		return $return;
	}

	protected function edgyInvalidOperatorsWithoutSpaces()
	{
		$return = array();

		$negative_edgy_operators = array(
			'||-', '&&-', '**-', '==-', '!=-', '<=-', '>=-', '<>-', '<-', '>-',
			'%-', '+-', '--', '*-', '/-', '.-', '!-', '^-',
		);

		foreach ($negative_edgy_operators as $operator)
		{
			// First the cases where these things are MISC
			foreach (array('negative', 'littlefloat') as $type)
			{
				if ($type == 'littlefloat' && $operator == '.-')
				{
					continue; // this an exception
				}

				$value = $this->valueTypes[$type];
				$expected = array(
					$value['token'],
					array('MISC', $operator),
					$value['token']
				);

				$return[] = array(
					"The \"{$operator}\" operator with {$type} values (no spaces)",
					$this->assembleCommonCondition($value['value'].$operator.$value['value']),
					$this->assembleCommonTokens($expected)
				);
			}

			// Now what to do when these things were followed by a digit
			foreach (array('int', 'bigfloat') as $type)
			{
				if ($type == 'bigfloat' && $operator == '.-')
				{
					continue; // this an exception
				}

				$value = $this->valueTypes[$type];
				$left = $value['token'];
				$right = array(
					$left[0],
					'-'.$left[1]
				);

				$expected = array(
					$left,
					array('OPERATOR', substr($operator, 0, -1)),
					$right
				);

				$return[] = array(
					"The \"{$operator}\" operator with {$type} values (no spaces)",
					$this->assembleCommonCondition($value['value'].$operator.$value['value']),
					$this->assembleCommonTokens($expected)
				);
			}
		}

		$float_edgy_operators = array(
			'||.', '&&.', '**.', '==.', '!=.', '<=.', '>=.', '<>.', '<.', '>.',
			'%.', '+.', '-.', '*.', '/.', '..', '!.', '^.'
		);

		foreach ($float_edgy_operators as $operator)
		{
			// First the cases where these things are MISC
			foreach (array('negative', 'littlefloat') as $type)
			{
				if ($type == 'littlefloat' && $operator == '..')
				{
					continue; // this an exception
				}

				$value = $this->valueTypes[$type];
				$expected = array(
					$value['token'],
					array('MISC', $operator),
					$value['token']
				);

				$return[] = array(
					"The \"{$operator}\" operator with {$type} values",
					$this->assembleCommonCondition($value['value'].$operator.$value['value']),
					$this->assembleCommonTokens($expected)
				);
			}

			// Now what to do when these things were followed by a digit
			// If followed by bigfloat we are in an error state and an exception
			// is thrown. So we will only test ints.
			$type = 'int';
			$value = $this->valueTypes[$type];
			$left = $value['token'];
			$right = array(
				$left[0],
				'.'.$left[1]
			);

			$expected = array(
				$left,
				array('OPERATOR', substr($operator, 0, -1)),
				$right
			);

			$return[] = array(
				"The \"{$operator}\" operator with {$type} values",
				$this->assembleCommonCondition($value['value'].$operator.$value['value']),
				$this->assembleCommonTokens($expected)
			);
		}

		return $return;
	}

	// Note: the number cases are covered in edgyInvalidOperatorsWithoutSpaces()
	protected function edgyDoubleDashWithoutSpaces()
	{
		$return = array();

		$operator = '--';

		// These become variables
		foreach(array('bool', 'variable', 'dash-variable') as $type)
		{
			$value = $this->valueTypes[$type];
			$token = $value['token'];
			$expected = array(
				array('VARIABLE', $token[1].$operator.$token[1]),
			);

			$return[] = array(
				"The \"{$operator}\" operator with {$type} values (no spaces)",
				$this->assembleCommonCondition($value['value'].$operator.$value['value']),
				$this->assembleCommonTokens($expected)
			);
		}

		// These see '--' as MISC
		foreach(array('string', 'dash-string', 'dot.string', 'intstring', 'simpletag', 'moduletag', 'tag_with_params') as $type)
		{
			$value = $this->valueTypes[$type];
			$expected = array(
				$value['token'],
				array('MISC', $operator),
				$value['token']
			);

			$return[] = array(
				"The \"{$operator}\" operator with {$type} values (no spaces)",
				$this->assembleCommonCondition($value['value'].$operator.$value['value']),
				$this->assembleCommonTokens($expected)
			);
		}

		return $return;
	}

	protected function validNumberTokens()
	{
		$return = array();

		$numbers = array(
			'0', '1', '10', '100',
			'0.', '1.', '10.', '100.',
			'.0', '.1', '.01', '.001',
			'0.1', '1.1', '10.01', '100.001'
		);

		foreach ($numbers as $number)
		{
			// Positive
			$expected = array(
				array('NUMBER', $number)
			);

			$return[] = array(
				"\"{$number}\" is a NUMBER token",
				$this->assembleCommonCondition($number),
				$this->assembleCommonTokens($expected)
			);

			// Negative
			$number = '-'.$number;
			$expected = array(
				array('NUMBER', $number)
			);

			$return[] = array(
				"\"{$number}\" is a NUMBER token",
				$this->assembleCommonCondition($number),
				$this->assembleCommonTokens($expected)
			);

		}

		return $return;
	}

	protected function validVariableTokens()
	{
		$return = array();

		$variables = array(
			'var', 'var-dash', 'var-two-dashes',
			'var--double', 'var---tripple',
			'var--double-plus', 'var---tripple--plus', 'var---tripple--plus-plus',
			'var_underscore', '_underscore_var', 'var_', 'var_underscore-dash',
			'var_-_rav', 's-__-s'
		);

		foreach ($variables as $variable)
		{
			$expected = array(
				array('VARIABLE', $variable)
			);

			$return[] = array(
				"\"{$variable}\" is a VARIABLE token",
				$this->assembleCommonCondition($variable),
				$this->assembleCommonTokens($expected)
			);
		}

		return $return;
	}
}