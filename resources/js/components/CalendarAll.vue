<template>
    <div class="WrapCalendar">
        <div class="card" v-cloak>
            <loading :active.sync="isLoading" :is-full-page="fullPage"/>

            <p  v-show="date_read!=''" class="h5 text-center mt-3">{{date_read}}</p>
            <template v-if="holidays.length>0">
                <div class="text-info text-center">Свята в цей день:</div>
                <ul class="mb-3 list-group list-group-flush">
                    <li v-for="holiday in holidays" class="list-group-item">
                        <a class="btn btn btn-outline-primary" :href="'/holiday/'+holiday.slug">{{holiday.title}}</a>
                    </li>
                </ul>
            </template>

            <post :items="items" :url="url"></post>

            <date-picker
                locale="uk"
                v-model="date"
                @dayclick="onDayClick"
                :masks="masks"
                :attributes="attrs"
                is-expanded
                class="mb-2"
            />
            <div class="typeCalendar mb-2">
                <label>Тип:</label>
                <select class="form-control" v-model="typecalendar">
                    <option v-for="(item,index) in datatypes" :key="item.id" :value="item.id">{{item.title}}</option>
                </select>
            </div>
            <div class="typeCalendar mb-2">
                  <a target="_blank" class="btn btn-outline-primary"
                     :href="'/files/Smeshinki_'+typecalendar_title()+'_'+date.getFullYear()+'.csv'">Завантажити для імпорту в Google Calendar</a>
            </div>

        </div>
    </div>
</template>
<script>
    import DatePicker from "v-calendar/lib/components/date-picker.umd";
    import Loading from "vue-loading-overlay";
    import "vue-loading-overlay/dist/vue-loading.css";
    import Post from "./items/Post"
    export default {
        name: "CalendarAll",
        data() {
            return {
                todos: [],
                date: "",
                typecalendar:'',// тип календаря
                datatypes:[],
                attrs: [],
                masks: {
                    input: "YYYY-MM-DD",
                },
                date_read:'',// дата которую пишем
                holidays:[],// праздники
                items: [],// записи
                url:'',// урл страницы даты
                isLoading: true,
                fullPage: false,
            };
        },
        props:[
            'datatype'
        ],
        components: {
            DatePicker,
            Loading,
            Post
        },
        created() {
            this.datatypes=JSON.parse(this.datatype);
            this.typecalendar=this.datatypes[0].id;
            this.setDate();
        },
        mounted(){
            this.date=new Date();
            this.typecalendar_title();
        },
        watch: {
            typecalendar(){
                this.items=[];
                this.holidays=[];
                this.loadSetDate();
                this.typecalendar_title()
            },
        },
        methods: {
            onDayClick(day) {
                this.date_read=day.ariaLabel;
                if (typeof day.attributes[0] != "undefined") {
                    this.isLoading = true;
                    axios
                        .post("/getPost", {
                            calendar_id: day.attributes[0].customData,
                            typecalendar:this.typecalendar
                        })
                        .then((res) => {
                            this.holidays = res.data.holidays;
                            this.items = res.data.posts;
                            this.url = res.data.url;
                        })
                        .catch((err) => {
                        })
                        .then(() => {
                            this.isLoading = false;
                        });
                } else {
                    this.items = [];
                }
            },
            // получить сегодняшние поздравления
            loadSetDate(){
                this.isLoading=true;
                this.date_read=this.dateLoc(this.date);
                let date=this.date.toISOString().slice(0, 10).replace('T', ' ');
                axios
                    .post("/getPostToday", {
                        typecalendar:this.typecalendar,
                        date:date
                    })
                    .then((res) => {
                        this.holidays = res.data.holidays;
                        this.items = res.data.posts;
                        this.url = res.data.url;
                    })
                    .catch((err) => {
                    })
                    .then(() => {
                        this.isLoading = false;
                    });
            },
            setDate() {
                this.isLoading=true;
                axios
                    .get("/getCalendar",{params:{
                            typecalendar:this.typecalendar
                        }})
                    .then((res) => {
                        this.attrs=[];
                        this.todos = res.data;
                        this.todos.forEach((el) => {
                            let date = new Date(el.year, el.month, el.date);
                            let todo = {
                                dates: date,
                                bar: {
                                    style: {
                                        backgroundColor: "brown",
                                    },
                                },
                                popover: {
                                    label: el.title,
                                },
                                customData: el.id,
                            };
                            this.attrs.push(todo);

                        });
                    })
                    .catch((err) => {
                        console.error(err);
                    })
                    .then(()=>{
                        this.isLoading=false;
                    })
            },
            dateLoc(date){
                let res='';
                let months = ['січня', 'лютого', 'березня', 'квітня', 'травня', 'червня', 'липня', 'серпня', 'вересня', 'жовтня', 'листопада', 'грудня'];
                let nominative = ['неділя', 'понеділок', 'вівторок', 'середа', 'четвер', 'п’ятниця', 'субота'];
                let month=date.getMonth();
                let d=date.getDate();
                let day=date.getDay();
                let year=date.getFullYear();
                res=nominative[day]+', '+d+' '+ months[month]+' '+year+ ' р.';
                return res;
            },
            typecalendar_title(){
                let title='';
                this.datatypes.forEach(element => {
                    if(element.id==this.typecalendar){
                        title=element.title;
                    }
                });
                return title;
            }
        },
    };
</script>
