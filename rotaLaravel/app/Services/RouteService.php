<?php

namespace App\Services;

use App\Models\Route;


class RouteService {

    protected $allRoutes;
    protected $pontos;

    public function __construct() {
        // Recupera os dados das rotas no BD.
        $this->allRoutes = Route::all()->toArray();
        // a função array_map abaixo gera um array somente com os pontos iniciais e finais 
        // que estão armazenados no BD.
        $this->pontos = array_map(function ($item) {
  
          return array('pi' => $item['ponto_inicial'], 
                       'pf' =>  $item['ponto_final']);
        
        }, $this->allRoutes);

    }


    public function calcMinRoute($data) {
      // Verifica se a rota desejada pelo usuário é uma rota direta. Por exemplo, A -> B.
      $rota_direta = $this->getTotalRoute($data['ponto_inicial'], $data['ponto_final']);
        
      if ($rota_direta) {

        $rota_direta = array_values($rota_direta)[0];

        return ['rotas_possiveis' => array(array('rota' => array($rota_direta['ponto_inicial'],
                                           $rota_direta['ponto_final']),
                                          'trajeto' => $rota_direta['distancia'],
                                          'custo' => $rota_direta['distancia']/$data['autonomia']*$data['l_combustivel'])),
                'rota_menor_custo' => ''];
      }
      
      // Caso não seja uma rota direta, verifica todas as rotas possíveis de acordo com
      // os pontos informados pelo usuário.
      $rotasPossiveis =  $this->getPossibleRoutes( array('ponto_inicial' => $data['ponto_inicial'], 
                                       'ponto_final' => $data['ponto_final']) ); 

      $rotasCalculadas = [];

      foreach($rotasPossiveis as $rotaPossivel) {

        $soma = $this->somaDistancia($rotaPossivel);
        $custo = $soma/$data['autonomia']*$data['l_combustivel'];

        array_push($rotasCalculadas, array('rota' => $rotaPossivel, 'trajeto' => $soma, 'custo' => $custo));
      }
      
      return ['rotas_possiveis' => $rotasCalculadas, 'rota_menor_custo' => $this->rotaMenorCusto($rotasCalculadas)[0]];
    }

    // retorna a rota com o menor custo
     private function rotaMenorCusto($rotas) {

      $custos = array_map(function($item) {
        return $item['custo'];
      }, $rotas);

      return array_filter($rotas, function($item) use($custos) {
          return $item['custo'] == min($custos);
      });

     }

     private function somaDistancia($rotaPossivel) {

      $somaKm = 0;

      for ($i=0;$i<count($rotaPossivel)-1;$i++) {

        $rota = array_filter($this->allRoutes, function($item) use($rotaPossivel, $i) {
          return ($item['ponto_inicial'] == $rotaPossivel[$i] &&
                  $item['ponto_final'] == $rotaPossivel[++$i]);
        });
        
        $somaKm += array_values($rota)[0]['distancia'];
      }

      return $somaKm;
    }

    private function getTotalRoute($pi, $pf) {
      return array_filter($this->allRoutes, function ($item) use($pi, $pf) {
        return ($item['ponto_inicial'] == $pi
                             && $item['ponto_final'] == $pf);
      });
    }



    private function getPossibleRoutes($route) {

        $rotasPossiveis = [];
        // Recupera todas as rotas cujo ponto inicial é igual ao ponto 
        // inicial informado pelo usuário.
        $rotas_iniciais_desejadas = $this->getRoutes($route, 'i');
        
        // O mesmo que o método acima, mas agora em relação aos pontos finais.
        $rotas_finais_desejadas = $this->getRoutes($route, 'f');

       foreach($rotas_iniciais_desejadas as $ri) {

         foreach($rotas_finais_desejadas as $rf) {
           // caso o ponto final de uma rota seja igual ao ponto inicial de outra, cujo o ponto final
           // desta é igual ao ponto final informado pelo usuário, então armazena-se essa possível
           // rota como um array numa variável local
           if($ri['pf'] == $rf['pi']) {
             array_push($rotasPossiveis, array($ri['pi'], $ri['pf'], $rf['pf']));
           } else {
           // caso o caso acima não seja true, então procura-se a um nível mais profundo mais rotas,
           // cujo ponto inicial é igual ao ponto final desta
            $rotas_iniciais = array_filter($this->pontos,
            function ($item) use($ri, $rf){
              return ($item['pi'] == $ri['pf'] && $item['pf'] != $rf['pf']);
           });
          
           // Pega essas rotas recuperadas acima e verifica se os ponto final delas é igual
           // ao ponto inicial das rotas que tem o ponto final igual ao informado (desejado) pelo
           // usuário. Caso positivo, armazena esses pontos um array e armazena na variável local
           foreach($rotas_iniciais as $rota_inicial) {
               if ($rota_inicial['pf'] == $rf['pi']) {
                 array_push($rotasPossiveis, array($ri['pi'], $ri['pf'], $rota_inicial['pf'], $rf['pf']));
               }
           }

            }
         }

       }
    
      return $rotasPossiveis;

     }
    
     // Este método retorna pares de pontos baseando-se no ponto inicial
     // ou final do parâmetro $route passado. Se o parâmetro $pos for igual a "i",
     // então retorna-se todos os pontos cujo ponto inicial é igual a rota inicial
     // armazenada no parâmetro $route. Caso "f", aplica-se aos pontos finais 
     private function getRoutes($route, $pos) {
       
        switch($pos) {
         case 'i': {
           return array_filter($this->pontos, function($item) use($route) {
             return ($item['pi'] == $route['ponto_inicial']);
           });
         }
         break;
         case 'f': {
           return array_filter($this->pontos, function($item) use($route) {
             return ($item['pf'] == $route['ponto_final']);
           });
         }
         break;
       }
       
     }
   
}