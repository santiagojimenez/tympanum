<?php
/**
 * DESCRIPTION
 *
 * @package Tympanum
 * @subpackage Tympanum Reader
 * @since 1.0.0
 */

$finder = (new PhpCsFixer\Config());

$header = <<<'EOF'
    DESCRIPTION

    @package Tympanum
    @subpackage Tympanum Reader
    EOF;

return (new PhpCsFixer\Config())
    ->setRules(array(

        // Array
        'array_syntax' => array('syntax' => 'long'),
        'no_multiline_whitespace_around_double_arrow' => true,
        'no_trailing_comma_in_singleline_array' => true,
        'no_whitespace_before_comma_in_array' => true,
        'normalize_index_brace' => true,
        'trim_array_spaces' => true,
        'whitespace_after_comma_in_array' => true,

        // Braces
        'braces' => array(
            'allow_single_line_anonymous_class_with_empty_body' => true,
            'allow_single_line_closure' => true,
            'position_after_control_structures' => 'same',
            'position_after_functions_and_oop_constructs' => 'same',
            'position_after_anonymous_constructs' => 'same',
        ),

        // Cases
        'constant_case' => array('case' => 'lower'),
        'lowercase_keywords' => true,
        'lowercase_static_reference' => true,
        'magic_constant_casing' => true,
        'native_function_casing' => true,
        'native_function_type_declaration_casing' => true,
        'cast_spaces' => array('space' => 'single'),
        'lowercase_cast' => true,
        'no_short_bool_cast' => true,
        'no_unset_cast' => true,
        'short_scalar_cast' => true,

        // Classes
        'class_attributes_separation' => array(
            'elements' => array(
                'const' => 'one',
                'method' => 'one',
                'property' => 'one',
                'trait_import' => 'none',
            ),
        ),
        'class_definition' => true,
        'no_blank_lines_after_class_opening' => true,
        'no_null_property_initialization' => true,
        'ordered_class_elements' => true,
        'protected_to_private' => true,
        'self_static_accessor' => true,
        'single_class_element_per_statement' => true,
        'single_trait_insert_per_statement' => false,
        'visibility_required' => false,

        // Comment
        'header_comment' => array(
            'header' => $header,
            'comment_type' => 'PHPDoc',
            'location' => 'after_open',
            'separate' => 'bottom',
        ),
        'multiline_comment_opening_closing' => true,
        'no_empty_comment' => true,
        'no_trailing_whitespace_in_comment' => true,
        'single_line_comment_style' => true,

        // Control Structure
        // 'control_structure_continuation_position' => array('position' => 'same_line'),
        'elseif' => true,
        'empty_loop_body' => true,

        // 'empty_loop_condition' => true,
        'include' => true,
        'no_alternative_syntax' => true,
        'no_break_comment' => true,
        'no_superfluous_elseif' => true,
        'no_trailing_comma_in_list_call' => true,
        'no_unneeded_control_parentheses' => true,
        'no_unneeded_curly_braces' => true,
        'no_useless_else' => true,
        'simplified_if_return' => false,
        'switch_case_semicolon_to_colon' => false,
        'switch_case_space' => true,
        'switch_continue_to_break' => true,
        'trailing_comma_in_multiline' => true,
        'yoda_style' => false,

        // Function Notation
        'function_declaration' => true,
        'function_typehint_space' => true,
        'lambda_not_used_import' => true,
        'method_argument_space' => true,
        'no_spaces_after_function_name' => true,
        'nullable_type_declaration_for_default_null_value' => true,
        'return_type_declaration' => true,
        'single_line_throw' => true,

        // Import
        'fully_qualified_strict_types' => true,
        'global_namespace_import' => false,
        'group_import' => true,
        'no_leading_import_slash' => true,
        'no_unused_imports' => true,
        // 'single_import_per_statement' => true,
        'single_line_after_imports' => true,

        // Language Construct
        'combine_consecutive_issets' => true,
        'combine_consecutive_unsets' => true,
        'declare_equal_normalize' => array('space' => 'single'),
        'declare_parentheses' => false,
        'explicit_indirect_variable' => true,
        'single_space_after_construct' => true,

        // List Notation
        'list_syntax' => array('syntax' => 'short'),

        // Namespace Notation
        'blank_line_after_namespace' => true,
        'clean_namespace' => true,
        'no_blank_lines_before_namespace' => false,
        'no_leading_namespace_whitespace' => true,
        'single_blank_line_before_namespace' => true,

        // Operator
        'binary_operator_spaces' => true,
        'concat_space' => false,
        'increment_style' => true,
        'new_with_braces' => true,
        'not_operator_with_space' => true,
        'not_operator_with_successor_space' => false,
        'object_operator_without_whitespace' => false,
        'operator_linebreak' => true,
        'standardize_increment' => false,
        'standardize_not_equals' => true,
        'ternary_operator_spaces' => true,
        'ternary_to_null_coalescing' => false,
        'unary_operator_spaces' => true,

        //PHP Tag
        'blank_line_after_opening_tag' => false,
        'echo_tag_syntax' => array(
            'format' => 'long',
            'long_function' => 'echo',
        ),
        'full_opening_tag' => true,
        'linebreak_after_opening_tag' => false,
        'no_closing_tag' => false,

        // PHPDoc
        'align_multiline_comment' => true,
        'general_phpdoc_annotation_remove' => false,
        'general_phpdoc_tag_rename' => false,
        'no_blank_lines_after_phpdoc' => true,
        'no_empty_phpdoc' => true,

        // 'no_empty_phpdoc_description' => false,
        'phpdoc_add_missing_param_annotation' => array('only_untyped' => false),
        'phpdoc_align' => true,
        'phpdoc_annotation_without_dot' => false,
        'phpdoc_indent' => true,
        'phpdoc_inline_tag_normalizer' => true,
        'phpdoc_line_span' => true,
        'phpdoc_no_access' => true,
        'phpdoc_no_alias_tag' => true,
        'phpdoc_no_empty_return' => true,
        'phpdoc_no_package' => false,
        'phpdoc_no_useless_inheritdoc' => true,
        'phpdoc_order_by_value' => false,
        'phpdoc_order' => true,
        'phpdoc_return_self_reference' => false,
        'phpdoc_scalar' => false,
        'phpdoc_separation' => true,
        'phpdoc_single_line_var_spacing' => true,
        'phpdoc_summary' => true,
        'phpdoc_tag_casing' => false,
        'phpdoc_tag_type' => true,
        'phpdoc_to_comment' => false,
        'phpdoc_trim_consecutive_blank_line_separation' => true,
        'phpdoc_trim' => true,
        'phpdoc_types' => true,
        'phpdoc_types_order' => false,
        'phpdoc_var_annotation_correct_order' => true,
        'phpdoc_var_without_name' => true,

        // Return Notation
        'no_useless_return' => true,
        'return_assignment' => true,
        'simplified_null_return' => true,

        // Semi-Colon Notation
        'simplified_null_return' => true,
        'no_empty_statement' => true,
        'no_singleline_whitespace_before_semicolons' => true,
        'semicolon_after_instruction' => true,
        'space_after_semicolon' => true,

        // String Notation
        'escape_implicit_backslashes' => true,
        'explicit_string_variable' => true,
        'heredoc_to_nowdoc' => true,
        'no_binary_string' => true,
        'simple_to_complex_string_variable' => true,
        'single_quote' => true,

        // Whitespace
        'array_indentation' => true,
        'blank_line_before_statement' => true,
        'compact_nullable_typehint' => true,
        'heredoc_indentation' => true,
        'indentation_type' => true,
        'line_ending' => true,
        'method_chaining_indentation' => true,
        'no_extra_blank_lines' => true,
        'no_spaces_around_offset' => true,
        'no_spaces_inside_parenthesis' => true,
        'no_trailing_whitespace' => true,
        'no_whitespace_in_blank_line' => true,
        'single_blank_line_at_eof' => true,
        'types_spaces' => array('space' => 'single'),
    ))
    ->setFinder(array($finder));
