<?php
$values = $_POST["formData"];

$rules = [
    "firstname" => "required",
    "lastname" => "required",
    "salary" => "required|positive"
];

function validate($values, $rules)
{
    $errors = [];
    $valid = true;

    foreach ($rules as $formKey => $rule) {
        $splitRules = explode("|", $rule);
        $errors[$formKey] = [];
        foreach ($splitRules as $splitRule) {
            $splitRuleWithOptions = explode(":", $splitRule);

            switch ($splitRuleWithOptions[0]) {
                case 'required':
                    if (!isset($values[$formKey]) || empty($values[$formKey]) || strlen($values[$formKey]) == 0) {
                        $errors[$formKey][] = $formKey . " is required";
                    }
                    break;
                case 'positive':
                    $values[$formKey] = intval($values[$formKey]);

                    if (!is_int($values[$formKey]) || $values[$formKey] <= 0) {
                        $errors[$formKey][] = $formKey . " must be a number biger than 0";
                    }
                    break;
            }
        }
    }
    foreach ($errors as $key => $error) {
        if (count($error) > 0) {
            $valid = false;
        }
    }
    return [$valid, $errors];
}

$result = validate($values, $rules);
echo json_encode($result);
