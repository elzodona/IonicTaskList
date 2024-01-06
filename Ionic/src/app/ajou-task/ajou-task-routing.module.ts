import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { AjouTaskPage } from './ajou-task.page';

const routes: Routes = [
  {
    path: '',
    component: AjouTaskPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class AjouTaskPageRoutingModule {}
