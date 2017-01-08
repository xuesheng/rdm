
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));

const app = new Vue({
    el: '#app',
    data: {
        id: 0,
        serial_number: '',
        name: '无',
        sponsor: '无',
        finished_at: '无',
        newSql: '',
        sqls: [],
        a_edit_hidden: true,
    },
    methods: {
        implode: function (event) {
            if (this.serial_number == '') {
                return;
            }
            this.$refs.button_fetch.disabled = true;
            this.$refs.input_serial_number.disabled = true;
            this.$http.post('/requirements/implode', {serial_number: this.serial_number}).then(
                function (response) {
                    if (response.body.code) {
                        alert(response.body.msg);
                        this.$refs.button_fetch.removeAttribute("disabled");
                        this.$refs.input_serial_number.removeAttribute("disabled");
                        return;
                    }

                    this.id = response.body.data.id;
                    this.name = response.body.data.name;
                    this.sponsor = response.body.data.sponsor;
                    this.finished_at = response.body.data.finished_at;
                    this.$refs.a_edit.href = '/requirements/edit/'+this.id;
                    this.a_edit_hidden = false;

                },
                function (response) {

                }
            )
        },
        addSql: function(sql) {
            if(sql != '' && !this.ifContains(sql, this.sqls)){
                this.$refs.button_add_sql.disabled = true;
                this.$http.post('/requirements/storeSql', {id: this.$refs.requirement_id.value, sql: sql}).then(function(response){
                    this.$refs.button_add_sql.disabled = false;

                    if (response.body.code) {
                        alert(response.body.msg);
                        return;
                    }

                    this.sqls.unshift(sql);
                    console.log(this.sqls);
                    this.newSql = '';


                }, function(response){

                });

            }
        },
        ifContains: function (item, items) {
            for(var i in items)
                if(item===items[i]) return true;
            return false;
        }


    }
});

$(function () {
    //获取上传文件的本地路径
    $('#code-file').change(function() {
        //$('#local-path').val($(this).val());
    });

});
