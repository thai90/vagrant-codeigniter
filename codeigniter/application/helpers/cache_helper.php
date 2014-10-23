<?php
    if(!function_exists('cacheTenFirstTweets')){
        function cacheTenFirstTweets($id, $tweets){
            $this->load->driver('cache');
            $this->cache->memcached->save($id,$data,CACHING_TIME);
        }
    }
?>