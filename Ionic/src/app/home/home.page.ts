import { Component } from '@angular/core';
import { MenuController, ModalController } from '@ionic/angular';
import { AjouTaskPage } from '../ajou-task/ajou-task.page';
import { TodoService } from '../todo.service';
import { UpdateTaskPage } from '../update-task/update-task.page';
import { Router } from '@angular/router';



@Component({
  selector: 'app-home',
  templateUrl: 'home.page.html',
  styleUrls: ['home.page.scss'],
})

export class HomePage {

  todolist: any;

  today:number= Date.now();

  searchTerm!: string

  userName!: string

  // filteredTodolist: any[] = [];
  selectedFilter: string = "un";


  constructor(public modalCtrl: ModalController, public todoservice: TodoService, private router: Router) {}

  ngOnInit() {
    this.getAllTask();
    this.selectedFilter = "one"
    const use = localStorage.getItem('user');
    const user = JSON.parse(use!);
    this.userName = user.name;
  };

  filterTasks() {
    const today = new Date();

    switch (this.selectedFilter) {
      case 'one':
        this.getAllTask();
        break;
      case 'un':
        this.todolist = this.todolist.filter((item:any) => this.isSameDay(today, this.parseTaskDate(item.taskDate)));
        break;
      case 'deux':
        this.todolist = this.todolist.filter((item:any) => this.isSameWeek(today, this.parseTaskDate(item.taskDate)));
        break;
      case 'quatre':
        this.todolist = this.todolist.filter((item:any) => this.isNextWeek(today, this.parseTaskDate(item.taskDate)));
        break;
      case 'trois':
        this.todolist = this.todolist.filter((item:any) => this.isSameMonth(today, this.parseTaskDate(item.taskDate)));
        break;
      default:
        this.getAllTask();
        break;
    }
  }

  parseTaskDate(dateString: string): Date {
    const taskDateParts = dateString.split('/');
    return new Date(
      parseInt(taskDateParts[2]),
      parseInt(taskDateParts[1]) - 1,
      parseInt(taskDateParts[0])
    );
  }

  isSameDay(date1: Date, date2: Date): boolean {
    return date1.getFullYear() === date2.getFullYear() &&
      date1.getMonth() === date2.getMonth() &&
      date1.getDate() === date2.getDate();
  }

  isSameWeek(date1: Date, date2: Date): boolean {
    const weekStart = new Date(date1);
    weekStart.setDate(date1.getDate() - date1.getDay());

    const weekEnd = new Date(weekStart);
    weekEnd.setDate(weekStart.getDate() + 6);

    return date2 >= weekStart && date2 <= weekEnd;
  }

  isNextWeek(today: Date, date: Date): boolean {
    const nextWeekStart = new Date(today);
    nextWeekStart.setDate(today.getDate() + 7);

    const nextWeekEnd = new Date(nextWeekStart);
    nextWeekEnd.setDate(nextWeekStart.getDate() + 6);

    return date >= nextWeekStart && date <= nextWeekEnd;
  }

  isSameMonth(date1: Date, date2: Date): boolean {
    return date1.getFullYear() === date2.getFullYear() &&
      date1.getMonth() === date2.getMonth();
  }


  getAllTask() {
    this.todoservice.allTask().subscribe((res:any)=>{
      this.todolist = res.data;
      // console.log(this.todolist)
    });
  }

  async addTask(){
    const modal =await this.modalCtrl.create({
      component:AjouTaskPage
    })
    modal.onDidDismiss().then(newTaskObj=>{
      this.getAllTask()
    })
    return await modal.present()
  }

  delete(key:number){
    this.todoservice.deleteTask(key).subscribe((res:any)=>{
      console.log(res);
      this.getAllTask()
    });
  }

  async update(selectedTask: any){
    // console.log(selectedTask);

    const modal = await this.modalCtrl.create({
      component:UpdateTaskPage,
      componentProps:{task:selectedTask}
    })

    modal.onDidDismiss().then(()=>{
      this.getAllTask()
    })
    return  await modal.present()
  }

  searchTasks(event: any) {
    this.searchTerm = event.detail.value;
    // console.log(this.searchTerm);
    if (this.searchTerm.length > 0) {
      this.todoservice.searchTask(this.searchTerm).subscribe((res:any)=>{
        // console.log(res);
        this.todolist = res.data;
      });
    }else{
      this.getAllTask();
    }

  }

  logout() {
    localStorage.clear();
    this.router.navigate(['']);
  }

}
