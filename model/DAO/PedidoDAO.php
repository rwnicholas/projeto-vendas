<?php
  require_once '../../conexao.php';
  require '../domain/Pedido.php';

  class PedidoDAO extends Connection{
    private $table = 'pedido';


    public function insert($pedido){

      $stmt = parent::prepareStatement("INSERT INTO pedido(data_compra,id_funcionario) VALUES(?,?)");
      $stmt->bind_param("si",$pedido->getData_compra(),$pedido->getId_funcionario());
      if($stmt->execute()){
        echo "Pedido inserido com sucesso!";
      }else{
        echo "Erro ao inserir dados!";
      }

      $stmt->close();

    }

    public function getAll(){
      $stmt = parent::prepareStatement("SELECT * FROM $this->table");
      if($stmt->execute()){
        $stmt->bind_result($id,$data_compra,$id_funcionario);


        $pedidos = array();

        while($stmt->fetch()){
          $result = new Pedido($id,$data_compra,$id_funcionario);
          $pedidos[] = $result;
        }
      }else{
        echo "Erro ao consultar o banco de dados!";
      }

      $stmt->close();
      return $pedidos;
    }

    public function getById($id){
      $stmt = parent::prepareStatement("SELECT * FROM $this->table WHERE id=?");
      $stmt->bind_param("i",$id);
      $stmt->execute();

      $stmt->bind_result($id,$data_compra,$id_funcionario);
      $stmt->fetch();

      $pedido = new Pedido($id,$data_compra,$id_funcionario);
      $stmt->close();
      return $pedido;
    }

  }
  $p = new PedidoDAO();
  $ped = new Pedido(5,"1/12/2017",500);
  $p->insert($ped);



 ?>
