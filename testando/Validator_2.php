<?php
/*
Exemplo de uma classe de validação de dados que pode ser usada para validar dados vindos de formulários enviados via GET, POST ou SESSION em PHP 8.2 armazenando as mensagens com session e exemplo de uso
Aqui está um exemplo de classe de validação de dados em PHP 8.2:
*/
<?php

namespace Validation;

class ValidateData
{

    public function __construct
	( 
		private array $errors = [];
		private array $data;
	)
    {       
    }

    public function validate(array $rules)
    {
        foreach ($rules as $field => $fieldRules) {
            $fieldRules = explode('|', $fieldRules);
            foreach ($fieldRules as $rule) {
                $value = $this->data[$field] ?? '';
                if (!$this->$rule($field, $value)) {
                    $this->errors[$field][] = $rule;
                }
            }
        }

        return empty($this->errors);
    }

    public function getErrors()
    {
        return $this->errors;
    }

    private function required(string $field, $value)
    {
        return !empty(trim($value));
    }

    private function minLength(string $field, $value, int $length)
    {
        return strlen($value) >= $length;
    }

    private function maxLength(string $field, $value, int $length)
    {
        return strlen($value) <= $length;
    }

    private function email(string $field, $value)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    private function isNumeric(string $field, $value)
    {
        return is_numeric($value);
    }

    public function saveErrorsToSession()
    {
        $_SESSION['errors'] = $this->errors;
    }

    public function hasErrors()
    {
        return !empty($this->errors);
    }
}

//Aqui está um exemplo de como usar a classe:

<?php

use Validation\ValidateData;

session_start();

$rules = [
    'name' => 'required|minLength:5|maxLength:255',
    'email' => 'required|email',
    'age' => 'required|isNumeric',
];

$data = [
    'name' => $_POST['name'] ?? '',
    'email' => $_POST['email'] ?? '',
    'age' => $_POST['age'] ?? '',
];

$validator = new ValidateData($data);

if ($validator->validate($rules)) {
    // Data is valid
} else {
    // Data is not valid
    $validator->saveErrorsToSession();
    header('Location: /form.php');
    exit;
}

/*
Neste exemplo, $rules é um array associativo que define as regras de validação
 para cada campo. As regras são separadas por | e podem ser qualquer método da classe ValidateData.

Quebrou o código
*/
