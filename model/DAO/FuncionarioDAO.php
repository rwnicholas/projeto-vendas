<?php
  require_once '../../conexao.php';
  require '../domain/Funcionario.php';

  class FuncionarioDAO extends Connection{
    private $table = 'funcionario';

    public function  insert($Funcionario) {
      $stmt = parent::prepareStatement("INSERT INTO funcionario(id, cargo, login, nome, senha) values (?, ?, ?, ?, ?)");
      $stmt->bind_param("issss", $Funcionario->getId(), $Funcionario->getCargo(), $Funcionario->getLogin(), $Funcionario->getNome(), $Funcionario->getSenha());

      if($stmt->execute()) {
        echo "Funcionario inserido com sucesso!";
      } else {
        echo "Erro ao inserir dados!";
      }
  }

  public function getAll(){
    $stmt = parent::prepareStatement("SELECT * from $this->table");

    if($stmt->execute()) {
      $stmt->bind_result($id, $cargo, $login, $nome, $senha);

      $funcionarios = array();

      while($stmt->fetch()) {
        $result = new Funcionario($id, $cargo, $login, $nome, $senha);
        $funcionarios[] = $result;
      }
    } else {
      echo "Erro ao consultar o banco de dados!";
    }

    $stmt->close();
    return $funcionarios;
  }

  public function getById($id) {
    $stmt = parent::prepareStatement("SELECT * from $this->table where id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $stmt->bind_result($id, $cargo, $login, $nome, $senha);
    $stmt->fetch();

    $funcionario = new Funcionario($id, $cargo, $login, $nome, $senha);
    print_r($funcionario);
    $stmt->close();
    return $funcionario;
  }

  public function deleteBYId($id){
    $stmt = parent::prepareStatement("DELETE FROM $this->table where id = ?");
    $stmt->bind_param("i", $id);

    if($stmt->execute()) {
      echo "<br> Excluído com sucesso";
    } else {
      echo "<br> Erro ao excluir!";
    }

    $stmt->close();
  }

  public function update($id, $novoFuncionario) {
    $stmt = parent::prepareStatement("update $this->table set cargo = ?, login = ?, nome = ?, senha = ? where id = ?");
    $stmt->bind_param("ssssi",  $novoFuncionario->getCargo(), $novoFuncionario->getLogin(), $novoFuncionario->getNome(), $novoFuncionario->getSenha(), $novoFuncionario->getId());

    if($stmt->execute()) {
      echo "Update realizado com sucesso!";
    } else {
      echo "Erro ao realizar update";
    }

    $stmt->close();
  }
}
?>