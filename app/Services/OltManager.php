<?php

namespace App\Services;

use App\Models\Olt;
use phpseclib3\Net\SSH2;

class OltManager {
    public function getStatus(Olt $olt)
    {
        // Try SNMP first
        $status = $this->checkViaSnmp($olt);

        if(!$status['online'] && $olt->ssh_username && $olt->ssh_password) {
            // Fallback to SSH
            $status = $this->checkViaSsh($olt);
        }

        return $status;
    }


    private function checkViaSnmp(Olt $olt)
    {
        try {
            $snmp = new \SNMP(\SNMP::VERSION_2C, $olt->ip_address, $olt->snmp_community);
            $uptime = $snmp->get('1.3.6.1.2.1.1.3.0'); // sysUpTime OID
            return [
                'online' => true,
                'uptime' => $this->formatSnmpUptime($uptime),
                'method' => 'SNMP'
            ];
        } catch (\Exception $e) {
            return [
                'online' => false,
                'error' => 'SNMP: ' . $e->getMessage()
            ];
        }
    }

    private function checkViaSsh(Olt $olt)
    {
        try {
            $ssh = new SSH2($olt->ip_address, $olt->ssh_port ?? 22);

            if (!$ssh->login($olt->ssh_username, $olt->ssh_password)) {
                throw new \Exception("SSH Authentication Failed");
            }

            $output = $ssh->exec('show uptime'); // Vendor-specific command
            return [
                'online' => true,
                'uptime' => $this->parseVendorUptime($output, $olt->type),
                'method' => 'SSH'
            ];
        } catch (\Exception $e) {
            return [
                'online' => false,
                'error' => 'SSH: ' . $e->getMessage()
            ];
        }
    }

    private function formatSnmpUptime($uptime)
    {
        // Convert SNMP uptime (timeticks) to human-readable format
        $seconds = (int)trim(explode('(', $uptime)[1]) / 100;
        return gmdate('d days H:i:s', $seconds);
    }

    private function parseVendorUptime($output, $type)
    {
        // Add vendor-specific parsing logic here
        return $output;
    }
}
