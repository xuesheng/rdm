
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
        alert_update_remark_hidden: true,
        alert_update_remark_success: false,
        alert_update_remark_fail: false
    },
    methods: {
        implode: function (event) {
            if (this.serial_number == '') {
                return;
            }
            this.$refs.button_fetch.disabled = true;
            this.$refs.input_serial_number.disabled = true;
            this.$http.post('/requirement/postimport', {serial_number: this.serial_number}).then(
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
                    this.$refs.a_edit.href = '/requirement/edit/'+this.id;
                    this.a_edit_hidden = false;

                },
                function (response) {

                }
            )
        },
        addSql: function(sql) {
            if(sql != '' && !this.ifContains(sql, this.sqls)){
                this.$refs.button_add_sql.disabled = true;
                this.$http.post('/requirement/storeSql', {id: this.$refs.requirement_id.value, sql: sql}).then(function(response){
                    this.$refs.button_add_sql.disabled = false;

                    if (response.body.code) {
                        alert(response.body.msg);
                        return;
                    }

                    this.sqls.unshift(sql);
                    this.newSql = '';


                }, function(response){

                });

            }
        },
        addRemark: function() {
            this.$refs.button_save_remark.disabled = true;
            var remark = this.$refs.textarea_remark.value;
            this.$http.post('/requirement/updateremark', {id: this.$refs.requirement_id.value, remark: remark}).then(function(response){
                this.$refs.button_save_remark.disabled = false;
                if (response.body.code) {
                    this.alert_update_remark_fail = true;
                } else {
                    this.alert_update_remark_success = true;
                }
                this.alert_update_remark_hidden = false;
                this.$refs.alert_update_remark.innerText = response.body.msg;
            }, function(response){

            });

        },
        ifContains: function (item, items) {
            for(var i in items)
                if(item===items[i]) return true;
            return false;
        }

    }
});

$(function () {
    //个人中心菜单项激活
    $("#user-center-sidebar > a").removeClass('active');
    $('#user-center-sidebar > a[href="'+document.URL+'"]').addClass('active');

});
