<script type="text/javascript">
    var component = {
        props: ['submit_url', 'scrape_url', 'redirect_url'],
        data: function () {
            return {
                ajaxUrl: this.submit_url,
                ajaxScrapeUrl: this.scrape_url,
                redirectUrl: this.redirect_url,
                dc: {
                    name: '',
                    tasks: []
                },
                newToken: ''
            };
        },
        watch: {
            tasks: function (val) {
                console.log(val);
            }
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
                task.urls.push(null);
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
                    var start_str = '/html/body/div/div/div[2]/div/div/div[2]';
                    value = value.substring(start_str.length);
                    value = '/html/body'+value;
                    //console.log(value);
                    $('.modal-body *').off('click');
                    //$('.modal-container').modal().hide();
                    $('#myModal').modal('hide');

                    task.data[d_index].value = value;
                });
            },
            openModalForUrlXpath: function (task, u_index) {
                $('#myModal').modal('show');
                $('.modal-body *').click(function(e)
                {
                    var value= getXPath( event.target );
                    var start_str = '/html/body/div/div/div[2]/div/div/div[2]';
                    value = value.substring(start_str.length);
                    value = '/html/body'+value;
                    //console.log(value);
                    $('.modal-body *').off('click');
                    //$('.modal-container').modal().hide();
                    $('#myModal').modal('hide');

                    task.urls[u_index] = value;
                    this.addEmptyUrlItemFortask(task); // need to add and remove that urls input field would be renewed
                    this.removeUrlFortask(task, u_index + 1);
                }.bind(this));
            },
            openTargetUrl: function(task) {
                //console.log(targetUrl);
                data = {
                    targetUrl: task.targetURL
                }
                if (this.newToken) {
                    data._token = this.newToken
                }
                jQuery.ajax({
                    url: this.ajaxScrapeUrl,
                    method: "POST",
                    dataType: "json",
                    data: data
                }).done(function (data) {
                    this.newToken = data.new_token;
                    if (data.newTargetUrl)
                        task.targetURL = data.newTargetUrl;
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
                        if (data.body.hasOwnProperty('contractStatus')) {
                            if (data.body.contractStatus == 1) {
                                alert("Data contract "+data.body.dataContract.name+" created!");
                            } else {
                                alert("Data contract "+data.body.dataContract.name+" is old one");
                            }
                        } else {
                            alert("Data contract "+data.body.name+" created!");
                        }
                    } else {
                        alert("Failed!");
                    }
                    document.location.href = this.redirectUrl;
                }.bind(this));
            }
        }
    }
    module.exports = component;
</script>