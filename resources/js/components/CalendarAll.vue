<template>
    <div class="WrapCalendar">
        <div class="card" v-cloak>
            <loading :active.sync="isLoading" :is-full-page="fullPage"/>
            <div class="typeCalendar mb-2">
                <label>Тип:</label>
                <select class="form-control" v-model="typecalendar">
                    <option v-for="(item,index) in datatypes" :key="item.id" :value="item.id">{{item.title}}</option>
                </select>
            </div>
            <date-picker
                locale="uk"
                v-model="date"
                @dayclick="onDayClick"
                :masks="masks"
                :attributes="attrs"
                is-expanded
            />
            <p  v-show="date_read!=''" class="h5 text-center mt-3">{{date_read}}</p>
            <post :items="items" :url="url"></post>
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
        },
        mounted(){
            this.date=new Date();
            this.loadSetDate();
        },
        watch: {
            typecalendar(){
                this.setDate();
                this.items=[];
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
                        })
                        .then((res) => {
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
                axios
                    .post("/getPostToday", {
                        typecalendar:this.typecalendar
                    })
                    .then((res) => {
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
            }
        },
    };
</script>
