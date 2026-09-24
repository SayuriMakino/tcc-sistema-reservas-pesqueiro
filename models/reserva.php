
<?php

class Reserva
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    public function listar()
    {
        $sql = "SELECT
                    r.id,
                    r.data_reserva,
                    r.status,
                    r.cliente_id,
                    c.nome AS cliente_nome
                FROM reserva r
                INNER JOIN cliente c
                    ON c.id = r.cliente_id
                ORDER BY r.data_reserva ASC, r.id ASC";

        $stmt = $this->conn->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id)
    {
        $sql = "SELECT *
                FROM reserva
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function cadastrar($dataReserva, $status, $clienteId)
    {
        $sql = "INSERT INTO reserva
                    (data_reserva, status, cliente_id)
                VALUES
                    (:data_reserva, :status, :cliente_id)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':data_reserva' => $dataReserva,
            ':status' => $status,
            ':cliente_id' => $clienteId
        ]);
    }

    public function editar($id, $dataReserva, $status, $clienteId)
    {
        $sql = "UPDATE reserva
                SET data_reserva = :data_reserva,
                    status = :status,
                    cliente_id = :cliente_id
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':id' => $id,
            ':data_reserva' => $dataReserva,
            ':status' => $status,
            ':cliente_id' => $clienteId
        ]);
    }

    public function excluir($id)
    {
        $sql = "DELETE FROM reserva
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':id' => $id
        ]);
    }
}
?>