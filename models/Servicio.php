<?php
/**
 * Modelo Servicio
 */

require_once __DIR__ . '/Database.php';

class Servicio extends Model {

    public function __construct() {
        parent::__construct();
        $this->table = 'servicios';
    }

    /**
     * Crear nuevo servicio
     */
    public function create($data) {
        $query = "INSERT INTO " . $this->table . "
                  (nombre, descripcion, precio_sugerido)
                  VALUES (:nombre, :descripcion, :precio_sugerido)";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':descripcion', $data['descripcion']);
        $stmt->bindParam(':precio_sugerido', $data['precio_sugerido']);

        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    /**
     * Actualizar servicio
     */
    public function update($id, $data) {
        $query = "UPDATE " . $this->table . "
                  SET nombre = :nombre, descripcion = :descripcion, precio_sugerido = :precio_sugerido
                  WHERE id = :id";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':descripcion', $data['descripcion']);
        $stmt->bindParam(':precio_sugerido', $data['precio_sugerido']);

        return $stmt->execute();
    }

    /**
     * Obtener total de veces que se realizó un servicio
     */
    public function getTotalRealizaciones($servicio_id) {
        $query = "SELECT COUNT(*) as total FROM ventas WHERE servicio_id = :servicio_id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':servicio_id', $servicio_id);
        $stmt->execute();

        $result = $stmt->fetch();
        return $result['total'];
    }

    /**
     * Obtener servicios más vendidos
     */
    public function getMasVendidos($limit = 10) {
        $query = "SELECT s.*, COUNT(v.id) as total_vendido, SUM(v.precio) as ingresos_total
                  FROM " . $this->table . " s
                  LEFT JOIN ventas v ON s.id = v.servicio_id
                  GROUP BY s.id
                  ORDER BY total_vendido DESC
                  LIMIT :limit";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
