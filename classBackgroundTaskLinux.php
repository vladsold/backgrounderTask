<?
namespace Backgrounder;
    
class classBackgroundTaskLinux
{
    public function launch($path = null, $timeout = 300, $once = true)
    {
        if (! file_exists(preg_replace('/^(\S+).*/', '$1', $path))) {
            throw new Exception('No such file to launch');
        }

        if ($once === true) {
            exec('ps -C php -o pid=,command=', $output);
            foreach ($output as $row) {
                preg_match('/-f (.*)/', $row, $result);
                if (!empty($result[1]) && $result[1] == $path) {
                    return false;
                }
            }
        }

        return exec('php -d max_execution_time='
            . $timeout . ' -f ' . $path
            . ' > /dev/null 2>&1 & echo $!', $output);
    }

    public function isRunning($pid)
    {
        exec('ps -p ' . $pid . ' -o command=', $output);

        if (empty($output)) {
            return false;
        }

        if (preg_match('/php -d max_execution_time=/', $output[0])) {
            return true;
        }

        return false;
    }

}
?>
