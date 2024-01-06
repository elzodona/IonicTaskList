import { Component, OnInit } from '@angular/core';
import { ModalController } from '@ionic/angular';
import { TodoService } from '../todo.service';

@Component({
  selector: 'app-ajou-task',
  templateUrl: './ajou-task.page.html',
  styleUrls: ['./ajou-task.page.scss'],
})
export class AjouTaskPage implements OnInit {

  categoris=['work','personnal', 'fun']
  taskName: any;
  taskDate: any;
  taskPriority: any;
  taskCategory: any;
  taskObject:  any;


  id: any;

  user: any;

  constructor(public modalcontrol:ModalController,public todoservice:TodoService) {
    const use = localStorage.getItem('user');
    this.user = JSON.parse(use!);
    this.id = this.user.id;
  }

  ngOnInit() {
    // this.categoris.push('work')
    // this.categoris.push('personal')
  }

  async dismis(){
    await this.modalcontrol.dismiss(this.taskObject)
  }

  selectCategoris(index:number){
    this.taskCategory=this.categoris[index]
   //this.categorySelectedCategory = this.categoris[index]
  //  console.log(this.categoris);
  }

  formatDate(inputDate: any) {
    const dateObject = new Date(inputDate);

    const day = dateObject.getDate();
    const month = dateObject.getMonth() + 1;
    const year = dateObject.getFullYear();

    const formattedDate = `${day < 10 ? '0' : ''}${day}/${month < 10 ? '0' : ''}${month}/${year}`;

    return formattedDate;
  }

  Addtask(){
    const taskData = {
      taskName: this.taskName,
      taskDate: this.formatDate(this.taskDate),
      priority: this.taskPriority,
      category: this.taskCategory,
      user_id: this.id
    };
    // console.log(taskData);

    this.todoservice.addTask(taskData).subscribe((res: any) => {
      console.log(res);
    });
  }

}
