<?php
if(!isset($argv[0])) { exit("What\n"); }
define( 'LOCK_FILE', "/var/run/".basename( $argv[0], ".php" ).".lock" ); 
if( isLocked() ) die( "Already running.\n" );
function isLocked() 
{ 
    # If lock file exists, check if stale.  If exists and is not stale, return TRUE 
    # Else, create lock file and return FALSE. 

    if( file_exists( LOCK_FILE ) ) 
    { 
        # check if it's stale 
        $lockingPID = trim( file_get_contents( LOCK_FILE ) ); 

       # Get all active PIDs. 
        $pids = explode( "\n", trim( `ps -e | awk '{print $1}'` ) ); 

        # If PID is still active, return true 
        if( in_array( $lockingPID, $pids ) )  return true; 

        # Lock-file is stale, so kill it.  Then move on to re-creating it. 
        echo "Removing stale lock file.\n"; 
        unlink( LOCK_FILE ); 
    } 
    
    file_put_contents( LOCK_FILE, getmypid() . "\n" ); 
    return false; 

} 