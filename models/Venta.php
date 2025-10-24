<?php
/**
 * Modelo Venta (CORE del sistema)
 */

require_once __DIR__ . '/Database.php';

class Venta extends Model {

    public function __construct() {
        parent::__construct();
        $this->table = 'ventas';
    }

    /**
     * Registrar nueva venta
     */
    public function create($data) {
        $query = "INSERT INTO " . $this->table . "
                  (cliente_id, barbero_id, servicio_id, precio, metodo_pago, nota)
                  VALUES (:cliente_id, :barbero_id, :servicio_id, :precio, :metodo_pago, :nota)";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':cliente_id', $data['cliente_id']);
        $stmt->bindParam(':barbero_id', $data['barbero_id']);
        $stmt->bindParam(':servicio_id', $data['servicio_id']);
        $stmt->bindParam(':precio', $data['precio']);
        $stmt->bindParam(':metodo_pago', $data['metodo_pago']);
        $stmt->bindParam(':nota', $data['nota']);

        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    /**
     * Actualizar venta
     */
    public function update($id, $data) {
        $query = "UPDATE " . $this->table . "
                  SET cliente_id = :cliente_id,
                      barbero_id = :barbero_id,
                      servicio_id = :servicio_id,
                      precio = :precio,
                      metodo_pago = :metodo_pago,
                      nota = :nota
                  WHERE id = :id";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':cliente_id', $data['cliente_id']);
        $stmt->bindParam(':barbero_id', $data['barbero_id']);
        $stmt->bindParam(':servicio_id', $data['servicio_id']);
        $stmt->bindParam(':precio', $data['precio']);
        $stmt->bindParam(':metodo_pago', $data['metodo_pago']);
        $stmt->bindParam(':nota', $data['nota']);

        return $stmt->execute();
    }

    /**
     * Obtener todas las ventas con información completa (JOINS)
     */
    public function getAllWithDetails() {
        $query = "SELECT v.*,
                         c.nombre as cliente_nombre, c.apellido as cliente_apellido,
                         b.nombre as barbero_nombre, b.apellido as barbero_apellido,
                         s.nombre as servicio_nombre
                  FROM " . $this->table . " v
                  LEFT JOIN clientes c ON v.cliente_id = c.id
                  LEFT JOIN barberos b ON v.barbero_id = b.id
                  LEFT JOIN servicios s ON v.servicio_id = s.id
                  ORDER BY v.fecha_venta DESC";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Ventas de HOY
     */
    public function getVentasHoy() {
        $query = "SELECT v.*,
                         c.nombre as cliente_nombre, c.apellido as cliente_apellido,
                         b.nombre as barbero_nombre, b.apellido as barbero_apellido,
                         s.nombre as servicio_nombre
                  FROM " . $this->table . " v
                  LEFT JOIN clientes c ON v.cliente_id = c.id
                  LEFT JOIN barberos b ON v.barbero_id = b.id
                  LEFT JOIN servicios s ON v.servicio_id = s.id
                  WHERE DATE(v.fecha_venta) = CURDATE()
                  ORDER BY v.fecha_venta DESC";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Total de ventas HOY
     */
    public function getTotalHoy() {
        $query = "SELECT SUM(precio) as total FROM " . $this->table . "
                  WHERE DATE(fecha_venta) = CURDATE()";

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch();

        return $result['total'] ?? 0;
    }

    /**
     * Estadísticas DIARIAS (para gráficas)
     */
    public function getEstadisticasDiarias($dias = 7) {
        $query = "SELECT DATE(fecha_venta) as fecha,
                         COUNT(*) as total_ventas,
                         SUM(precio) as ingresos
                  FROM " . $this->table . "
                  WHERE fecha_venta >= DATE_SUB(CURDATE(), INTERVAL :dias DAY)
                  GROUP BY DATE(fecha_venta)
                  ORDER BY fecha ASC";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':dias', $dias, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Estadísticas SEMANALES (últimas X semanas)
     */
    public function getEstadisticasSemanales($semanas = 4) {
        $query = "SELECT YEARWEEK(fecha_venta, 1) as semana,
                         COUNT(*) as total_ventas,
                         SUM(precio) as ingresos
                  FROM " . $this->table . "
                  WHERE fecha_venta >= DATE_SUB(CURDATE(), INTERVAL :semanas WEEK)
                  GROUP BY YEARWEEK(fecha_venta, 1)
                  ORDER BY semana ASC";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':semanas', $semanas, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Estadísticas MENSUALES (últimos X meses)
     */
    public function getEstadisticasMensuales($meses = 12) {
        $query = "SELECT DATE_FORMAT(fecha_venta, '%Y-%m') as mes,
                         COUNT(*) as total_ventas,
                         SUM(precio) as ingresos
                  FROM " . $this->table . "
                  WHERE fecha_venta >= DATE_SUB(CURDATE(), INTERVAL :meses MONTH)
                  GROUP BY DATE_FORMAT(fecha_venta, '%Y-%m')
                  ORDER BY mes ASC";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':meses', $meses, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Métodos de pago más usados
     */
    public function getMetodosPagoEstadisticas() {
        $query = "SELECT metodo_pago, COUNT(*) as total, SUM(precio) as ingresos
                  FROM " . $this->table . "
                  GROUP BY metodo_pago
                  ORDER BY total DESC";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Ranking de barberos por productividad
     */
    public function getRankingBarberos($periodo = 'mes') {
        $whereClause = '';

        switch($periodo) {
            case 'hoy':
                $whereClause = "WHERE DATE(v.fecha_venta) = CURDATE()";
                break;
            case 'semana':
                $whereClause = "WHERE YEARWEEK(v.fecha_venta, 1) = YEARWEEK(CURDATE(), 1)";
                break;
            case 'mes':
                $whereClause = "WHERE MONTH(v.fecha_venta) = MONTH(CURDATE()) AND YEAR(v.fecha_venta) = YEAR(CURDATE())";
                break;
        }

        $query = "SELECT b.nombre, b.apellido,
                         COUNT(*) as total_servicios,
                         SUM(v.precio) as ingresos_generados
                  FROM " . $this->table . " v
                  LEFT JOIN barberos b ON v.barbero_id = b.id
                  $whereClause
                  GROUP BY v.barbero_id
                  ORDER BY total_servicios DESC";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
