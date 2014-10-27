<?php
/**
 * Copyright 2013 Stéphane Depierrepont (aka Toorop)
 *
 * Authors :
 *  - Stéphane Depierrepont (aka Toorop)
 *  - Florian Jensen (aka flosoft) : https://github.com/flosoft
 *  - Gillardeau Thibaut (aka Thibautg16) 
 *
 * Licensed under the Apache License, Version 2.0 (the "License").
 * You may not use this file except in compliance with the License.
 * A copy of the License is located at
 *
 * http://www.apache.org/licenses/LICENSE-2.0.txt
 *
 * or in the "license" file accompanying this file. This file is distributed
 * on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 */

/*
 * cloned from VPS - Slartibardfast - 2014-06-30
*/

namespace Ovh\Ip;

use Guzzle\Http\Message\Response;

use Ovh\Common\AbstractClient;
use Ovh\Common\Exception\BadMethodCallException;

use Ovh\Ip\Exception\IpException;

class IPClient extends AbstractClient
{

    /**
     * Get IPBlockProperties
     *
     * @param string $ipBlock
     * @return string Json
     * @throws Exception\IpException
     * @throws Exception\IpNotFoundException
     */ 
	public function getIPBlockProperties($ipblock)
    {
        try {
            $r = $this->get('ip/' . urlencode($ipblock))->send();
        } catch (\Exception $e) {
            throw new IpException($e->getMessage(), $e->getCode(), $e);
        }
        return $r->getBody(true);
    }
	
    /**
     * set IPBlockProperties
     *
     * @param string $description
     * @return string Json
     * @throws Exception\IpException
     * @throws Exception\IpNotFoundException

only seems to return null on success

     */ 
    public function setIPBlockProperties($ipblock,$description)
    {
		$payload = array(
			'description' => $description
		 );
	
        try {
            $r = $this->put('ip/' . urlencode($ipblock), array('Content-Type' => 'application/json;charset=UTF-8'), json_encode($payload))->send();
        } catch (\Exception $e) {
            throw new IpException($e->getMessage(), $e->getCode(), $e);
        }
        return $r->getBody(true);
    }
	
	
    /**
     * Get IPBlockArp
     *
     * @param string $ipBlock
     * @return string Json
     * @throws Exception\IpException
     * @throws Exception\IpNotFoundException
     */ 
	public function getIPBlockArp($ipblock)
    {
        try {
            $r = $this->get('ip/' . urlencode($ipblock) . '/arp')->send();
        } catch (\Exception $e) {
            throw new IpException($e->getMessage(), $e->getCode(), $e);
        }
        return $r->getBody(true);
    }
	
    /**
     * Get IPBlockedInfo - returns information about the specific IP in the IPBlock
     *
     * @param string $ipBlock
	 * @param string $ip 
     * @return string Json
     * @throws Exception\IpException
     * @throws Exception\IpNotFoundException
     */ 
	public function getIPBlockedInfo($ipblock, $ip)
    {
        try {
            $r = $this->get('ip/' . urlencode($ipblock) . '/arp/' . $ip)->send();
        } catch (\Exception $e) {
            throw new IpException($e->getMessage(), $e->getCode(), $e);
        }
        return $r->getBody(true);
    }

    /**
     * Get Reverse - returns Reverse IP of selected Block
     *
     * @param string $ipBlock
     * @return string Json
     * @throws Exception\IpException
     * @throws Exception\IpNotFoundException
     */ 
	public function getReverse($ipblock)
    {
        try {
            $r = $this->get('ip/' . urlencode($ipblock) . '/reverse/')->send();
        } catch (\Exception $e) {
            throw new IpException($e->getMessage(), $e->getCode(), $e);
        }
        return $r->getBody(true);
    }
	

    /**
     * Get ReverseProperties - returns information about the specific IP Reverse
     *
     * @param string $ipBlock
	 * @param string $ip 
     * @return string Json
     * @throws Exception\IpException
     * @throws Exception\IpNotFoundException
     */ 
	public function getReverseProperties($ipblock, $ip)
    {
        try {
            $r = $this->get('ip/' . urlencode($ipblock) . '/reverse/' . $ip)->send();
        } catch (\Exception $e) {
            throw new IpException($e->getMessage(), $e->getCode(), $e);
        }
        return $r->getBody(true);
    }

    /**
     * Set ReverseProperties - returns information about the specific IP Reverse
     *
     * @param string $ipBlock
	 * @param string $ip 
     * @return string Json
     * @throws Exception\IpException
     * @throws Exception\IpNotFoundException
     */ 
	public function setReverseProperties($ipblock,$ip,$reverse)
    {
		if (!$ipblock)
			throw new BadMethodCallException('Parameter $ipblock is missing.');
		if (!$ip)
			throw new BadMethodCallException('Parameter $ip is missing.');
	//	if (!$reverse)
	//		throw new BadMethodCallException('Parameter $reverse is missing.');
	//	if (inet_pton($ip) !== false)
	//		throw new BadMethodCallException('Parameter $ip is invalid.');
	//	if (substr($reverse, -1) != ".")
	//		throw new BadMethodCallException('Parameter $reverse must end in ".".');
		$payload = array(
			'ipReverse' => $ip, 
			'reverse' => $reverse
		 );
        try {
            $r = $this->post('ip/' . urlencode($ipblock) . '/reverse', array('Content-Type' => 'application/json;charset=UTF-8'), json_encode($payload))->send();
        } catch (\Exception $e) {
            throw new IpException($e->getMessage(), $e->getCode(), $e);
        }
        return $r->getBody(true);
    }
	
	/*
	* deleteReverseProperties
	*
	* @param string ipblock 
	* @param string ip
	*
	* @returns mixed
	*/
	public function deleteReverseProperties($ipblock,$ip)
    {
		if (!$ipblock)
			throw new BadMethodCallException('Parameter $ipblock is missing.');
		if (!$ip)
			throw new BadMethodCallException('Parameter $ip is missing.');
        try {
            $r = $this->delete('ip/' . urlencode($ipblock) . '/reverse/' . $ip)->send();
        } catch (\Exception $e) {
            throw new IpException($e->getMessage(), $e->getCode(), $e);
        }
        return $r->getBody(true);
    }

    /**
     * Get Spam  - returns list of IPs on spam control in block
     *
     * @param string $ipBlock
	 * @param string $spamstate { "blockedForSpam", "unblocked", "unblocking"}
     * @return string Json
     * @throws Exception\IpException
     * @throws Exception\IpNotFoundException
     */ 
	public function getSpam($ipblock, $spamstate)
    {
		if (!$ipblock)
			throw new BadMethodCallException('Parameter $ipblock is missing.');
		if (!$spamstate)
			throw new BadMethodCallException('Parameter $spamstate is missing.');
		switch ($spamstate) {
			case "blockedForSpam":
			case "unblocked":
			case "unblocking":
				break;
			default:
				throw new BadMethodCallException('Parameter $spamstate is invalid.');
		}
        try {
            $r = $this->get('ip/' . urlencode($ipblock) . '/spam/?state=' . $spamstate)->send();
        } catch (\Exception $e) {
            throw new IpException($e->getMessage(), $e->getCode(), $e);
        }
        return $r->getBody(true);
    }
	
	/**
     * Get SpamProperties  - returns Properties of IP on Spam
     *
     * @param string $ipBlock
	 * @param string $ipv4 
     * @return string Json
     * @throws Exception\IpException
     * @throws Exception\IpNotFoundException
     */ 
	public function getSpamProperties($ipblock, $spamstate)
    {
		if (!$ipblock)
			throw new BadMethodCallException('Parameter $ipblock is missing.');
		if (!$ipv4)
			throw new BadMethodCallException('Parameter $ipv4 is missing.');
        try {
            $r = $this->get('ip/' . urlencode($ipblock) . '/spam/' . $ipv4)->send();
        } catch (\Exception $e) {
            throw new IpException($e->getMessage(), $e->getCode(), $e);
        }
        return $r->getBody(true);
    }

	/**
     * Get SpamStats  - returns Statistics of IP on Spam
     *
     * @param string $ipBlock
	 * @param string $ipv4 
     * @return string Json
     * @throws Exception\IpException
     * @throws Exception\IpNotFoundException
     */ 
	public function getSpamStats($ipblock, $spamstate, $fromdate, $todate)
    {
		if (!$ipblock)
			throw new BadMethodCallException('Parameter $ipblock is missing.');
		if (!$ipv4)
			throw new BadMethodCallException('Parameter $ipv4 is missing.');
		if (!$fromdate)
			throw new BadMethodCallException('Parameter $fromdate is missing.');
		if (!$todate)
			throw new BadMethodCallException('Parameter $todate is missing.');
        try {
            $r = $this->get('ip/' . urlencode($ipblock) . '/spam/' . $ipv4 .'/stats?from='.urlencode($fromdate).'&to='.urlencode($todate))->send();
        } catch (\Exception $e) {
            throw new IpException($e->getMessage(), $e->getCode(), $e);
        }
        return $r->getBody(true);
    }

    /**
     * Set UnblockSpam - Trigger unblocking of IP on Spam block
     *
     * @param string $ipBlock
	 * @param string $ipv4 
     * @return string Json
     * @throws Exception\IpException
     * @throws Exception\IpNotFoundException
     */ 
	public function setUnblockSpam($ipblock,$ipv4)
    {
		if (!$ipblock)
			throw new BadMethodCallException('Parameter $ipblock is missing.');
		if (!$ipv4)
			throw new BadMethodCallException('Parameter $ipv4 is missing.');
		
        try {
            $r = $this->post('ip/' . urlencode($ipblock) . '/spam/' . $ipv4 .'/unblock' )->send();
        } catch (\Exception $e) {
            throw new IpException($e->getMessage(), $e->getCode(), $e);
        }
        return $r->getBody(true);
    }

    /**
     * move IpBlock
     *
     * @param string $ipBlock
	 * @param string $destination
	 * 
     * @return string Json
     * @throws Exception\IpException
     */ 
	public function moveIpBlock($ipblock, $ipv4, $dest)
    {
		if (!$ipblock)
			throw new BadMethodCallException('Parameter $ipblock is missing.');
		if (!$ipv4)
			throw new BadMethodCallException('Parameter $ipv4 is missing.');
		if (!$dest)
			throw new BadMethodCallException('Parameter $dest is missing.');
		
        $payload = array(
			'to' => $dest
		 );
        try {
            $r = $this->post('ip/' . urlencode($ipblock) . '/move', array('Content-Type' => 'application/json;charset=UTF-8'), json_encode($payload))->send();
        } catch (\Exception $e) {
            throw new IpException($e->getMessage(), $e->getCode(), $e);
        }
        return $r->getBody(true);
    }

    /**
     * park IpBlock
     *
     * @param string $ipBlock
	 * @param string $ipv4 
	 *
     * @return string Json
     * @throws Exception\IpException
	 *
	 * untested!!
     */ 
	public function parkIpBlock($ipblock,$ipv4)
    {
		if (!$ipblock)
			throw new BadMethodCallException('Parameter $ipblock is missing.');
		if (!$ipv4)
			throw new BadMethodCallException('Parameter $ipv4 is missing.');
		
        try {
            $r = $this->post('ip/' . urlencode($ipblock) . '/park'  )->send();
        } catch (\Exception $e) {
            throw new IpException($e->getMessage(), $e->getCode(), $e);
        }
        return $r->getBody(true);
    }


/*
		/ip/{ip}/firewall/*				not implemented
		/ip/{ip}/game/*					not implemented
g		/ip/{ip}/license/cpanel 		TODO
g		/ip/{ip}/license/directadmin	TODO
g		/ip/{ip}/license/plesk			TODO
g		/ip/{ip}/license/virtuozzo		TODO
g		/ip/{ip}/license/windows		TODO
	** no worklight? **
g/p		/ip/{ip}/migrationToken			TODO
g/p/d	/ip/{ip}/mitigation/*			TODO
g/p		/ip/{ip}/mitigationProfiles		TODO
g/p		/ip/{ip}/task/p					TODO
p		/ip/{ip}/terminate				TODO

*/
}