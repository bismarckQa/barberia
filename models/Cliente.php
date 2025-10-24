<?php
/**
 * Modelo Cliente
 */

require_once __DIR__ . '/Database.php';

class Cliente extends Model {

    public function __construct() {
        parent::__construct();
        $this->table = 'clientes';
    }

    /**
     * Crear nuevo cliente
     */
    public function create($data) {
        $query = "INSERT INTO " . $this->table . "
                  (nombre, apellido, edad, telefono, notas, estado)
                  VALUES (:nombre, :apellido, :edad, :telefono, :notas, :estado)";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':apellido', $data['apellido']);
        $stmt->bindParam(':edad', $data['edad']);
        $stmt->bindParam(':telefono', $data['telefono']);
        $stmt->bindParam(':notas', $data['notas']);
        $stmt->bindParam(':estado', $data['estado']);

        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    /**
     * Actualizar cliente
     */
    public function update($id, $data) {
        $query = "UPDATE " . $this->table . "
                  SET nombre = :nombre, apellido = :apellido, edad = :edad,
                      telefono = :telefono, notas = :notas, estado = :estado
                  WHERE id = :id";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':apellido', $data['apellido']);
        $stmt->bindParam(':edad', $data['edad']);
        $stmt->bindParam(':telefono', $data['telefono']);
        $stmt->bindParam(':notas', $data['notas']);
        $stmt->bindParam(':estado', $data['estado']);

        return $stmt->execute();
    }

    /**
     * Buscar clientes por nombre o teléfono
     */
    public function search($term) {
        $query = "SELECT * FROM " . $this->table . "
                  WHERE nombre LIKE :term OR apellido LIKE :term OR telefono LIKE :term
                  ORDER BY nombre ASC";

        $stmt = $this->db->prepare($query);
        $searchTerm = "%{$term}%";
        $stmt->bindParam(':term', $searchTerm);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Obtener historial de visitas del cliente (desde tabla ventas)
     */
    public function getHistorial($cliente_id) {
        $query = "SELECT v.*, b.nombre as barbero_nombre, b.apellido as barbero_apellido,
                         s.nombre as servicio_nombre, v.fecha_venta
                  FROM ventas v
                  LEFT JOIN barberos b ON v.barbero_id = b.id
                  LEFT JOIN servicios s ON v.servicio_id = s.id
                  WHERE v.cliente_id = :cliente_id
                  ORDER BY v.fecha_venta DESC";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':cliente_id', $cliente_id);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Obtener estadísticas del cliente (calculadas desde ventas)
     */
    public function getEstadisticas($cliente_id) {
        $query = "SELECT
                    COUNT(*) as total_visitas,
                    SUM(precio) as total_gastado,
                    MAX(fecha_venta) as ultima_visita
                  FROM ventas
                  WHERE cliente_id = :cliente_id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':cliente_id', $cliente_id);
        $stmt->execute();

        return $stmt->fetch();
    }

    /**
     * Obtener solo clientes activos
     */
    public function getActivos() {
        $query = "SELECT * FROM " . $this->table . " WHERE estado = 'activo' ORDER BY nombre ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
