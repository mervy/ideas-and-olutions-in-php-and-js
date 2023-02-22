<?php
namespace App\Models;
/**
Classe validação dados como get post session com abstração dados php8.2 formulários 
Aqui está um exemplo de uma classe de validação de dados 
que pode ser usada para validar dados vindos de formulários 
enviados via GET, POST ou SESSION em PHP 8.2:
*/
class Validator
{
  private $errors = [];

  public function validate($data, $rules)
  {
    foreach ($rules as $field => $fieldRules) {
      $fieldValue = $data[$field] ?? null;
      foreach ($fieldRules as $rule) {
        $ruleName = $rule[0];
        $ruleValue = $rule[1];

        switch ($ruleName) {
          case 'required':
            if (empty($fieldValue)) {
              $this->errors[$field][] = 'Field is required';
            }
            break;
          case 'minLength':
            if (strlen($fieldValue) < $ruleValue) {
              $this->errors[$field][] = "Minimum length is $ruleValue characters";
            }
            break;
          case 'maxLength':
            if (strlen($fieldValue) > $ruleValue) {
              $this->errors[$field][] = "Maximum length is $ruleValue characters";
            }
            break;
          case 'email':
            if (!filter_var($fieldValue, FILTER_VALIDATE_EMAIL)) {
              $this->errors[$field][] = 'Invalid email format';
            }
            break;
        }
      }
    }
  }

  public function failed()
  {
    return !empty($this->errors);
  }

  public function getErrors()
  {
    return $this->errors;
  }
}
?>
Neste exemplo, a classe Validator tem um método validate que recebe dois parâmetros: $data e $rules. O primeiro é um array com os dados a serem validados e o segundo é um array com as regras de validação para cada campo. O método validate verifica se cada campo atende às suas respectivas regras de validação e armazena os erros em um array $errors. O método failed retorna true se houver erros e false caso contrário. O método getErrors retorna o array de erros.

Aqui está como você pode usar a classe Validator para validar dados de formulários enviados via POST:
<?php
<?php
use App\Models\Validator;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = $_POST;

  $validator = new Validator();
  $validator->validate($data, [
    'email' => [
      ['required'],
      ['email']
    ],
    'password' => [
      ['required'],
      ['minLength', 8],
      ['maxLength', 16]
    ]
  ]);
?>
