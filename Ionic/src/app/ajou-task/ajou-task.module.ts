import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { AjouTaskPageRoutingModule } from './ajou-task-routing.module';

import { AjouTaskPage } from './ajou-task.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    AjouTaskPageRoutingModule
  ],
  declarations: [AjouTaskPage]
})
export class AjouTaskPageModule {}
