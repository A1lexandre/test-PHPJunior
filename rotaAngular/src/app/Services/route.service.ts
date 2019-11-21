import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class RouteService {

  constructor(private http: HttpClient) { }

  getBestRoute(value) {
    return this.http.get(`http://localhost:8000/api/route?ponto_inicial=${value.pi}
                         &ponto_final=${value.pf}&autonomia=${value.autonomia}&l_combustivel=${value.l_combus}`);
  }
}
