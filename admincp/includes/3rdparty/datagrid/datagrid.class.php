<?php

class DataGrid {
    private $db_conn;
    private $sql;
    private $caption = "";
    private $debug = false;
    
    public $safeMode = false; // Propriedade pública acessada diretamente em alguns arquivos

    public function __construct($debug_mode = false, $messaging = true, $unique_prefix = "", $dir = "") {
        $this->debug = $debug_mode;
    }

    public function DataSource($db_conn, $sql, $default_order_field = "", $default_order_type = "") {
        $this->db_conn = $db_conn;
        $this->sql = $sql;
    }

    public function AllowAjax($option) {}
    public function SetLayouts($layouts) {}
    public function SetModes($modes) {}
    public function AllowMultirowOperations($option) {}
    public function SetMultirowOperations($operations) {}
    public function SetHttpGetVars($vars) {}
    public function SetCaption($caption) { $this->caption = $caption; }
    public function AllowPrinting($option) {}
    public function AllowExporting($option, $dir) {}
    public function AllowExportingTypes($types) {}
    public function SetDetailsModeTableProperties($props) {}
    public function SetTableEdit($table, $pk, $condition) {}
    public function WriteCssClass() {
        echo '<style>
            .dg-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
            .dg-table th, .dg-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
            .dg-table th { background-color: #f2f2f2; }
            .dg-table tr:nth-child(even) { background-color: #f9f9f9; }
            .dg-error { color: red; padding: 10px; border: 1px solid red; background: #ffeeee; }
        </style>';
    }

    public function Bind() {
        if (!empty($this->caption)) {
            echo "<h3>" . htmlspecialchars($this->caption) . "</h3>";
        }

        if (!$this->db_conn) {
            echo "<div class='dg-error'>Database connection not set.</div>";
            return;
        }

        // Tentar executar a query
        // O objeto $db_conn parece ser PEAR DB ou similar.
        // Vamos tentar métodos comuns: query(), execute(), ou usar mysqli direto se for o link
        
        $result = null;
        $error = "";

        // Se for um objeto PEAR DB
        if (method_exists($this->db_conn, 'query')) {
            $result = $this->db_conn->query($this->sql);
            if (\PEAR::isError($result)) {
                $error = $result->getMessage();
                $result = null;
            }
        } 
        // Se for mysqli link direto (improvável dado o código visto, mas possível)
        elseif ($this->db_conn instanceof \mysqli) {
            $result = $this->db_conn->query($this->sql);
            if (!$result) $error = $this->db_conn->error;
        }
        else {
             $error = "Unknown DB Connection type: " . get_class($this->db_conn);
        }

        if ($error) {
            echo "<div class='dg-error'>Error executing query: " . htmlspecialchars($error) . "</div>";
            if ($this->debug) echo "<pre>" . htmlspecialchars($this->sql) . "</pre>";
            return;
        }

        if ($result) {
            echo "<table class='dg-table'>";
            $header_printed = false;
            
            // PEAR DB fetchRow loop
            if (method_exists($result, 'fetchRow')) {
                while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
                    if (!$header_printed) {
                        echo "<thead><tr>";
                        foreach ($row as $key => $val) {
                            echo "<th>" . htmlspecialchars($key) . "</th>";
                        }
                        echo "</tr></thead><tbody>";
                        $header_printed = true;
                    }
                    echo "<tr>";
                    foreach ($row as $val) {
                        echo "<td>" . htmlspecialchars($val) . "</td>";
                    }
                    echo "</tr>";
                }
            } 
            // Mysqli fetch loop
            elseif ($result instanceof \mysqli_result) {
                 while ($row = $result->fetch_assoc()) {
                    if (!$header_printed) {
                        echo "<thead><tr>";
                        foreach ($row as $key => $val) {
                            echo "<th>" . htmlspecialchars($key) . "</th>";
                        }
                        echo "</tr></thead><tbody>";
                        $header_printed = true;
                    }
                    echo "<tr>";
                    foreach ($row as $val) {
                        echo "<td>" . htmlspecialchars($val) . "</td>";
                    }
                    echo "</tr>";
                }
            }
            
            if (!$header_printed) {
                echo "<tr><td>No records found</td></tr>";
            } else {
                echo "</tbody>";
            }
            echo "</table>";
        }
    }
}
?>