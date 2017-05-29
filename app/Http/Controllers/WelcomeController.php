<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    
    /*
    |--------------------------------------------------------------------------
    | Welcome Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders the "marketing page" for the application and
    | is configured to only allow guests. Like most of the other sample
    | controllers, you are free to modify or remove it as you desire.
    |
    */
    
    public $marca = array();
    public $matriz = array();
    public $indices = array();
    public $filas = "";
    public $cols = "";
    public $buscado = "OIE";
    public $vertivalDecendente = "";
    public $verticalAcendente = "";
    public $horizontalDecendente = "";
    public $horizontalAcendente = "";
    public $diagonalDecendente = "";
    public $diagonalAcendente = "";
    public $transversalDecendente = "";
    public $transversalAcendente = "";
    public $total = 0;
    
    
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    
    /**
     * Show the application welcome screen to the user.
     *
     * @return Response
     */
    public function index()
    {
        return view('welcome');
    }
    
    
    
    public function verificarsopa(Request $request)
    {
        
        $input        = $request->all();
        $array_limpio = array();
        
        
        
        $e = explode("\n\n", $input['dataInput']);
        
        
        foreach ($e as $key => $value) {
            
            if ($value != "") {
                
                array_push($array_limpio, trim(strtoupper($e[$key])));
                
            }
        }
        
     //   dump($array_limpio);
    //    exit; 
        
        foreach ($array_limpio as $key2 => $value2) {
            
            $cf          = explode("\n", $value2);
            $this->filas = count($cf);
            
            
            
            $this->cols = 0;
            $ff         = 0;
            
            
            foreach ($cf as $key3 => $value3) {
                
                $this->cols = ($this->cols < strlen($value3)) ? strlen($value3) : $this->cols;
                
                $this->matriz[$ff] = $value3; 
                
                $ff++;
                
            }
            
            foreach ($this->matriz as $key7 => $value7) {
                
                for ($i = 0; $i < $this->cols; $i++) {
                    
                    $this->matriz[$key7][$i] = empty($this->matriz[$key7][$i]) ? " " : $this->matriz[$key7][$i];
                    
                }
            }
            
            
            $this->unica_vez();
            
           exit;
            
        }
        
    }
    




    
    public function unica_vez()
    {
        
        $this->seteaCeros();
        
        $this->buscarConBactraking(0, 0, "OIE");
        
    }
    
    public function buscarConBactraking($x, $y, $palabra)
    {
        
        if ($x >= 0 && $y >= 0 && $x < count($this->marca) && $y < count($this->marca[0]) && $this->marca[$x][$y] != 1) {
            
            
            $temp_data = "";
            
            if (strlen($this->buscado) > $this->filas) {
                
                
                for ($i = 0; $i < strlen($this->buscado); $i++) {
                    
                    if (empty($this->matriz[$i])) {
                        
                        
                        for ($z = 0; $z < $this->cols; $z++) {
                            $temp_data .= " ";
                        }
                        
                        $this->matriz[$i] = $temp_data;
                        $temp_data        = "";
                        
                    }
                }
            }
            
            
            foreach ($this->matriz as $key8 => $value8) {
                
                $temp8 = str_split($value8);
                
                foreach ($temp8 as $key9 => $value9) {
                    
                    if ($value9 == $this->buscado[0]) {
                        
                        array_push($this->indices, array(
                            $key8,
                            $key9
                        ));
                    }
                    
                }
                
            }
            
            foreach ($this->indices as $key10 => $value10) {
                
                
                $this->recorrer($value10[0], $value10[1], $this->buscado, 0, 0);
                
            }
            
            
            $this->imprirResultado($this->buscado);
            
           // exit;
            
        } else {
            return;
        }
        
    }
    
    
    
    public function noVistos()
    {
        
        foreach ($this->marca as $key4 => $value4) {
            
            foreach ($value4 as $key5 => $value5) {
                
                if ($this->marca[$key4][$key5] == 0) {
                    
                    return 1;
                }
            }
        }
        return 0;
    }
    
    
    public function marcarVistos()
    {
        
        foreach ($this->marca as $key4 => $value4) {
            
            foreach ($value4 as $key5 => $value5) {
                
                $this->marca[$key4][$key5] = 1;
            }
        }
    }
    
    
    public function seteaCeros()
    {
        
        for ($i = 0; $i < $this->filas; $i++) {
            
            for ($e = 0; $e < $this->cols; $e++) {
                
                $this->marca[$i][$e] = 0;
            }
        }
        
    }
    
    
    public function recorrer($x, $y, $comparacion, $m, $i)
    {
        
        
        if ($m < strlen($comparacion)) {
            if ($i < count($this->matriz)) {
                
                if ($x + $i < count($this->matriz)) {
                    
                    $this->vertivalDecendente .= $this->matriz[$x + $i][$y];
                }
                
                if ($x - $i >= 0) {
                    $this->verticalAcendente .= $this->matriz[$x - $i][$y];
                }
                
                
                if ($y + $i < strlen($this->matriz[0])) {
                    $this->horizontalDecendente .= $this->matriz[$x][$y + $i];
                }
                
                
                if ($y - $i >= 0) {
                    $this->horizontalAcendente .= $this->matriz[$x][$y - $i];
                }
                
                if ($x + $i < count($this->matriz) && $y + $i < strlen($this->matriz[0])) {
                    $this->diagonalDecendente .= $this->matriz[$x + $i][$y + $i];
                }
                
                if ($x - $i >= 0 && $y - $i >= 0) {
                    $this->diagonalAcendente .= $this->matriz[$x - $i][$y - $i];
                    // dump($this->diagonalAcendente);
                }
                
                if ($x - $i >= 0 && $y + $i < strlen($this->matriz[0])) {
                    $this->transversalAcendente .= $this->matriz[$x - $i][$y + $i];
                }
                if ($y - $i >= 0 && $x + $i < count($this->matriz)) {
                    $this->transversalDecendente .= $this->matriz[$x + $i][$y - $i];
                }
                
                $this->recorrer($x, $y, $comparacion, $m, $i + 1);
            } else {
                $this->recorrer($x, $y, $comparacion, $m + 1, 0);
            }
        }
    }
    
    
    public function imprirResultado($comparacion)
    {
        
        
        if (strpos($this->horizontalDecendente, $comparacion) !== false) {
            
            $this->total++;
        }
        
        
        if (strpos($this->vertivalDecendente, $comparacion) !== false) {
            
            $this->total++;
        }
        
        if (strpos($this->verticalAcendente, $comparacion) !== false) {
            
            $this->total++;
        }
        
        if (strpos($this->horizontalAcendente, $comparacion) !== false) {
            $this->total++;
        }
        
        if (strpos($this->diagonalAcendente, $comparacion) !== false) {
            $this->total++;
        }
        
        if (strpos($this->diagonalDecendente, $comparacion) !== false) {
            $this->total++;
        }
        
        if (strpos($this->transversalAcendente, $comparacion) !== false) {
            $this->total++;
        }
        
        if (strpos($this->transversalDecendente, $comparacion) !== false) {
            $this->total++;
        }
        
        echo json_encode(array("resultado"=>$this->total));
    }
    
}
