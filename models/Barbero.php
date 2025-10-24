<?php
/**
 * Modelo Barbero
 */

require_once __DIR__ . '/Database.php';

class Barbero extends Model {

    public function __construct() {
        parent::__construct();
        $this->table = 'barberos';
    }

    /**
     * Crear nuevo barbero
     */
    public function create($data) {
        $query = "INSERT INTO " . $this->table . "
                  (nombre, apellido, telefono, fecha_ingreso, estado)
                  VALUES (:nombre, :apellido, :telefono, :fecha_ingreso, :estado)";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':apellido', $data['apellido']);
        $stmt->bindParam(':telefono', $data['telefono']);
        $stmt->bindParam(':fecha_ingreso', $data['fecha_ingreso']);
        $stmt->bindParam(':estado', $data['estado']);

        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    /**
     * Actualizar barbero
     */
    public function update($id, $data) {
        $query = "UPDATE " . $this->table . "
                  SET nombre = :nombre, apellido = :apellido, telefono = :telefono,
                      fecha_ingreso = :fecha_ingreso, estado = :estado
                  WHERE id = :id";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':apellido', $data['apellido']);
        $stmt->bindParam(':telefono', $data['telefono']);
        $stmt->bindParam(':fecha_ingreso', $data['fecha_ingreso']);
        $stmt->bindParam(':estado', $data['estado']);

        return $stmt->execute();
    }

    /**
     * Obtener solo barberos activos
     */
    public function getActivos() {
        $query = "SELECT * FROM " . $this->table . " WHERE estado = 'activo' ORDER BY nombre ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Estadísticas de servicios HOY
     */
    public function getServiciosHoy($barbero_id) {
        $query = "SELECT COUNT(*) as total
                  FROM ventas
                  WHERE barbero_id = :barbero_id
                  AND DATE(fecha_venta) = CURDATE()";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':barbero_id', $barbero_id);
        $stmt->execute();

        $result = $stmt->fetch();
        return $result['total'];
    }

    /**
     * Estadísticas de servicios ESTA SEMANA
     */
    public function getServiciosSemana($barbero_id) {
        $query = "SELECT COUNT(*) as total
                  FROM ventas
                  WHERE barbero_id = :barbero_id
                  AND YEARWEEK(fecha_venta, 1) = YEARWEEK(CURDATE(), 1)";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':barbero_id', $barbero_id);
        $stmt->execute();

        $result = $stmt->fetch();
        return $result['total'];
    }

    /**
     * Estadísticas de servicios ESTE MES
     */
    public function getServiciosMes($barbero_id) {
        $query = "SELECT COUNT(*) as total
                  FROM ventas
                  WHERE barbero_id = :barbero_id
                  AND MONTH(fecha_venta) = MONTH(CURDATE())
                  AND YEAR(fecha_venta) = YEAR(CURDATE())";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':barbero_id', $barbero_id);
        $stmt->execute();

        $result = $stmt->fetch();
        return $result['total'];
    }

    /**
     * Total de servicios realizados
     */
    public function getTotalServicios($barbero_id) {
        $query = "SELECT COUNT(*) as total FROM ventas WHERE barbero_id = :barbero_id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':barbero_id', $barbero_id);
        $stmt->execute();

        $result = $stmt->fetch();
        return $result['total'];
    }

    /**
     * Servicios más realizados por el barbero
     */
    public function getServiciosMasRealizados($barbero_id, $limit = 5) {
        $query = "SELECT s.nombre, COUNT(*) as total
                  FROM ventas v
                  LEFT JOIN servicios s ON v.servicio_id = s.id
                  WHERE v.barbero_id = :barbero_id
                  GROUP BY v.servicio_id
                  ORDER BY total DESC
                  LIMIT :limit";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':barbero_id', $barbero_id);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
