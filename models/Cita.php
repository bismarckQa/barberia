<?php
/**
 * Modelo Cita
 */

require_once __DIR__ . '/Database.php';

class Cita extends Model {

    public function __construct() {
        parent::__construct();
        $this->table = 'citas';
    }

    /**
     * Crear nueva cita
     */
    public function create($data) {
        $query = "INSERT INTO " . $this->table . "
                  (nombre_cliente, telefono, fecha_cita, hora_cita, nota, estado)
                  VALUES (:nombre_cliente, :telefono, :fecha_cita, :hora_cita, :nota, :estado)";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':nombre_cliente', $data['nombre_cliente']);
        $stmt->bindParam(':telefono', $data['telefono']);
        $stmt->bindParam(':fecha_cita', $data['fecha_cita']);
        $stmt->bindParam(':hora_cita', $data['hora_cita']);
        $stmt->bindParam(':nota', $data['nota']);
        $stmt->bindParam(':estado', $data['estado']);

        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    /**
     * Actualizar cita
     */
    public function update($id, $data) {
        $query = "UPDATE " . $this->table . "
                  SET nombre_cliente = :nombre_cliente, telefono = :telefono,
                      fecha_cita = :fecha_cita, hora_cita = :hora_cita,
                      nota = :nota, estado = :estado
                  WHERE id = :id";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nombre_cliente', $data['nombre_cliente']);
        $stmt->bindParam(':telefono', $data['telefono']);
        $stmt->bindParam(':fecha_cita', $data['fecha_cita']);
        $stmt->bindParam(':hora_cita', $data['hora_cita']);
        $stmt->bindParam(':nota', $data['nota']);
        $stmt->bindParam(':estado', $data['estado']);

        return $stmt->execute();
    }

    /**
     * Obtener citas de hoy
     */
    public function getCitasHoy() {
        $query = "SELECT * FROM " . $this->table . "
                  WHERE DATE(fecha_cita) = CURDATE()
                  ORDER BY hora_cita ASC";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Obtener citas por fecha
     */
    public function getCitasPorFecha($fecha) {
        $query = "SELECT * FROM " . $this->table . "
                  WHERE DATE(fecha_cita) = :fecha
                  ORDER BY hora_cita ASC";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Obtener próximas citas (estado: esperando)
     */
    public function getProximas($limit = 10) {
        $query = "SELECT * FROM " . $this->table . "
                  WHERE estado = 'esperando' AND fecha_cita >= CURDATE()
                  ORDER BY fecha_cita ASC, hora_cita ASC
                  LIMIT :limit";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Cambiar estado de la cita
     */
    public function cambiarEstado($id, $estado) {
        $query = "UPDATE " . $this->table . " SET estado = :estado WHERE id = :id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':estado', $estado);

        return $stmt->execute();
    }
}
