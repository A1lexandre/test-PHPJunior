import { Component } from '@angular/core';

import { RouteService } from './Services/route.service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  title = 'rotaAngular';

  dados: any;
  err: any;

  constructor(private routeService: RouteService) { }

  submit(form) {
    this.dados = '';
    this.err = '';
    this.routeService.getBestRoute(form.value).subscribe(
      data => this.dados = data,
      error => this.err = error.error,
    )
  }
}
