<script type="text/javascript">
    var component = {
        props: ['submit_url', 'scrape_url'],
        data: function () {
            return {
                ajaxUrl: this.submit_url,
                ajaxScrapeUrl: this.scrape_url,
                dc: {
                    name: '',
                    tasks: []
                }
            };
        },
        methods: {
            addTask: function(taskType) {
                task = this.getEmptyTaskObj();
                task.type = taskType;
                this.dc.tasks.push(task);
            },
            addEmptyDataItemFortask: function(task) {
                task.data.push(this.getEmptyDataObj());
            },
            addEmptyUrlItemFortask: function(task) {
                task.urls.push("");
            },
            removeDataItemFortask: function (task, dataIndex) {
                task.data.splice(dataIndex, 1);
            },
            removeUrlFortask: function (task, uIndex) {
                task.urls.splice(uIndex, 1);
            },
            removeTask: function(taskIndex) {
                this.dc.tasks.splice(taskIndex, 1);
            },
            getEmptyTaskObj: function() {
                return {
                    type: '',
                    targetURL: '',
                    data: [],
                    urls: []
                }
            },
            getEmptyDataObj: function() {
                return {
                    key: "",
                    value: ""
                }
            },
            openModalForXpath: function (task, d_index) {
                $('#myModal').modal('show');
                $('.modal-body *').click(function(e)
                {
                    var value= getXPath( this );
                    var start_str = '/html/body/div/div[2]/div/div/div[2]';
                    value = value.substring(start_str.length);
                    value = '/body'+value;
                    //console.log(value);
                    $('.modal-body *').off('click');
                    //$('.modal-container').modal().hide();
                    $('#myModal').modal('hide');

                    task.data[d_index].value = value;
                });
            },
            openTargetUrl: function(targetUrl) {
                console.log(targetUrl);

                jQuery.ajax({
                    url: this.ajaxScrapeUrl,
                    method: "POST",
                    dataType: "json",
                    data: {targetUrl: targetUrl}
                }).done(function (data) {
                    if (data.status) {
                        $('.modal-body').html(data.body);
                        alert('Target URL content retrieved!');
                    } else {
                        alert("Sorry but unable to get remote page content!");
                    }
                }.bind(this));
            },
            submit: function() {
                var dataForSend = $.extend({},this.dc);
                //var dataForSend = JSON.parse(JSON.stringify(this.dc)); // If you do not use functions within your object
                for (var i=0; i<dataForSend.tasks.length; i++) {
                    var dataItem = {};
                    var task = dataForSend.tasks[i];
                    for (var j=0; j<task.data.length; j++) {
                        dataItem[task.data[j].key] = task.data[j].value;
                    }
                    delete dataForSend.tasks[i].data;
                    dataForSend.tasks[i].data = dataItem;
                }
                jQuery.ajax({
                    url: this.ajaxUrl,
                    method: "POST",
                    dataType: "json",
                    data: dataForSend
                }).done(function (data) {
                    if (data.status) {
                        alert("Data contract "+data.body.name+" created!");
                    } else {
                        alert("Data contract was not created!");
                    }
                    document.location.href = '/data-contracts';
                }.bind(this));
            }
        }
    }
    module.exports = component;
</script>