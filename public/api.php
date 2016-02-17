<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="./include/strm/youtubedataapi_v3_list/style.css" />
    <title>YouTubeAPIv3サンプル | 動画情報取得（認証なし）</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>
        /* 開発キー
            https://code.google.com/apis/console
        */
        var APIKEY="AIzaSyCZ-nOw7gNZ7v0DHApJjyCKcC8Nx6khz_M";

        /* 取得する動画のID、カンマ区切りで複数指定可 */
        var VIDEO_IDs="cyTmeyb1Hbk";

        var limit=0;
        var pageToken="",s="",ss="";
        var allcnt=0,j=0,totalResults=0,resultsPerPage=0,total=0;
        var topicIds_ary=[],topicIds_length=0,topicIds_cnt=0;

        /* APIロード */
        function onJSClientLoad() {
            dbg("★onJSClientLoad");
            gapi.client.setApiKey(APIKEY);
            gapi.client.load('youtube', 'v3', makeRequest);
        }
        var requestOptions = {
            id:VIDEO_IDs,//YouTube動画IDをカンマ区切りで複数指定可
            part:"id, snippet, contentDetails, player, statistics, status, topicDetails"
        };
        /* APIリクエスト */
        function makeRequest(){
            dbg("★makeRequest:"+pageToken);
            if(pageToken){
                requestOptions.pageToken=pageToken;
            }
            var request=gapi.client.request({
                mine:"",
                path:"/youtube/v3/videos",
                params:requestOptions
            });
            request.execute(function(resp) {
                dbg(resp);
                if(resp.error){
                    $("#message").html(resp.error.message);
                }else{
                    output(resp,pageToken);
                }
            });
        }
        /* HTMl出力 */
        function output(resp,pageTokenFLG){
            dbg("★output");
            pageToken=resp.nextPageToken;
            if(pageTokenFLG=="" && resp.pageInfo){
                var pageInfo=resp.pageInfo;
                s+="<li>pageInfo:";
                    s+="<ul>";
                        s+="<li>1ページに含まれる結果数:"+pageInfo.resultsPerPage+"</li>";
                        s+="<li>結果の合計数:"+pageInfo.totalResults+"</li>";
                    s+="</ul>";
                s+="</li>";
                resultsPerPage=resp.pageInfo.resultsPerPage;//APIレスポンスに含まれる結果の数。
                totalResults=resp.pageInfo.totalResults;//結果セット内の結果の合計数。
                
                if(limit>0){
                    totalResults=limit;
                }
                total=Math.floor(totalResults/resultsPerPage);
                
                if(totalResults<=resultsPerPage){
                    total=1;
                }else if(totalResults%resultsPerPage!=0){
                    total++;
                }
                dbg("total:"+total+"/resultsPerPage:"+resultsPerPage+"/totalResults:"+totalResults);
                $("#results").append("<h2>Results</h2><ul>"+s+"</ul>");
                s="";
            }
            itemOutput(resp.items);
            allcnt++;
            if(allcnt<total){
                makeRequest();
            }else{
                $("#results").append("<h2>Items</h2><ul>"+s+"</ul>");
            }
        }
        function itemOutput(items){
            dbg(items);
            dbg("allcnt:"+allcnt+"/j:"+j);
            $.each(items, function(i, item){
                if(limit!=0 && j>=limit) return;
                j=(allcnt*resultsPerPage)+i+1
                /* id */
                s+="<li><b>id:"+((item.id)?item.id:"no id")+"</b><ul>";
                /* snippet */
                if(item.snippet){
                    s+="<li><b>snippet</b>:<ul>";
                    var snippet=item.snippet;
                    s+=(snippet.title)?"<li>動画タイトル（title）:"+snippet.title+"</li>":"";
                    s+=(snippet.channelId)?"<li>チャンネルID（channelId）:"+snippet.channelId+"</li>":"";
                    s+=(snippet.channelTitle)?"<li>チャンネルタイトル（channelTitle）:"+snippet.channelTitle+"</li>":"";
                    s+=(snippet.categoryId)?"<li>カテゴリID(categoryId):"+snippet.categoryId+"</li>":"";
                    s+=(snippet.publishedAt)?"<li>公開日（publishedAt）:"+snippet.publishedAt+"</li>":"";
                    s+=(snippet.description)?"<li>説明文（description）:"+snippet.description+"</li>":"";
                    if(snippet.thumbnails && snippet.thumbnails.default){
                        s+="<li>サムネイル（thumbnails）：<br /><img src='"+snippet.thumbnails.default.url+"' /></li>";
                    }
                    if(snippet.tags){
                        s+="<li>タグ（tags）："+snippet.tags.join(", ")+"</li>";
                    }
                    s+="</ul></li>";
                }
                /* contentDetails */
                if(item.contentDetails){
                    s+="<li><b>contentDetails</b>：<ul>";
                    var contentDetails=item.contentDetails;
                    s+=(contentDetails.caption)?"<li>字幕の有無（caption）:"+contentDetails.caption+"</li>":"";
                    s+=(contentDetails.definition)?"<li>画質（definition）:"+contentDetails.definition+"</li>":"";
                    s+=(contentDetails.dimension)?"<li>次元（dimension）:"+contentDetails.dimension+"</li>":"";
                    s+=(contentDetails.duration)?"<li>動画の長さ（duration）:"+contentDetails.duration+"</li>":"";
                    s+=(contentDetails.licensedContent)?"<li>licensedContent:"+contentDetails.licensedContent+"</li>":"";
                    s+="</ul></li>";
                }
                /* fileDetails */
                if(item.fileDetails){
                    dbg(item.fileDetails);
                }
                /* player */
                if(item.player){
                    s+="<li><b>player</b>：<ul>";
                    var player=item.player;
                    s+=(player.embedHtml)?"<li>埋め込みタグ（player.embedHtml）:<textarea style='width:100%;height:3em;'>"+player.embedHtml+"</textarea></li>":"";
                    s+="</ul></li>";
                }
                /* processingDetails */
                if(item.processingDetails){
                    s+="<li><b>processingDetails</b>：<ul>";
                    var processingDetails=item.processingDetails;
                    s+=(processingDetails.processingStatus)?"<li>processingStatus:"+processingDetails.processingStatus+"</li>":"";
                    s+="</ul></li>";
                }
                /* recordingDetails */
                if(item.recordingDetails){
                    dbg(item.recordingDetails);
                }
                /* statistics */
                if(item.statistics){
                    s+="<li><b>statistics</b>：<ul>";
                    var statistics=item.statistics;
                    s+=(statistics.commentCount)?"<li>コメント数（commentCount）:"+statistics.commentCount+"</li>":"";
                    s+=(statistics.subscriberCount)?"<li>登録者数（subscriberCount）:"+statistics.subscriberCount+"</li>":"";
                    s+=(statistics.videoCount)?"<li>動画数（videoCount）:"+statistics.videoCount+"</li>":"";
                    s+=(statistics.viewCount)?"<li>再生回数（viewCount）:"+statistics.viewCount+"</li>":"";
                    s+="</ul></li>";
                }
                /* status */
                if(item.status){
                    s+="<li><b>status</b>：<ul>";
                    var status=item.status;
                    s+=(status.embeddable)?"<li>埋め込みを許可（embeddable）:"+status.embeddable+"</li>":"";
                    s+=(status.license)?"<li>ライセンス（license）:"+status.license+"</li>":"";
                    s+=(status.privacyStatus)?"<li>公開ステイタス（privacyStatus）:"+status.privacyStatus+"</li>":"";
                    s+=(status.publicStatsViewable)?"<li>publicStatsViewable:"+status.publicStatsViewable+"</li>":"";
                    s+=(status.uploadStatus)?"<li>アップロードステイタス（uploadStatus）:"+status.uploadStatus+"</li>":"";
                    s+="</ul></li>";
                }
                /* suggestions */
                if(item.suggestions){
                    dbg(item.suggestions);
                }
                /* topicDetails */
                if(item.topicDetails && item.topicDetails.topicIds){
                    // Freebase topic IDs一覧
                    s+="<li><b>topicIds.opicIds</b>："+item.topicDetails.topicIds.join("　")+"</li>";
                    for(var y in item.topicDetails.topicIds){
                        topicIds_ary.push(item.topicDetails.topicIds[y]);
                    }
                }
                s+="</ul></li>";
            });
        }
        var dbg=function(str){
            try{
                if(window.console && console.log){
                    console.log(str);
                }
            }catch(err){
                //alert("error:"+err);
            }
        }
    </script>
    <script src="https://apis.google.com/js/client.js?onload=onJSClientLoad"></script>
</head>
<body>
    <h1>設置サンプル：[YouTube API(v3) - 動画情報取得</h1>
    <div id="results"></div>
</body>
</html>