################################################################################
# Name:          ICTPRG434_435 AT2 - Asset Audit for Midtown IT network
# Purpose:       Collect information on all computers used on the Midtown IT
#                network and keep a Microsoft Excel (CSV) file up to date with
#                the following information on all computers
# Requires:      To work with Windows and Linux operating systems
# Author:        Waldemar Francisco Mapua
# Author ID:     473437398
# Contributors:  Waldemar Mapua
# Copyright:
#
# License:
#
#
#
# Created:       14/06/2024
#
# Last Modified: 15/06/2024
#
# Versioning     Version 1.0.01
################################################################################

import csv
import os
import platform
import psutil
import socket
import struct 
import datetime
import GPUtil
import distutils

def getSystemInfo():
    systemInfo = {}

    # System Time - Current timestamp
    systemInfo['systemTime'] = datetime.datetime.now().strftime("%Y-%m-%d %H:%M:%S")
    # Computer Name
    systemInfo['computerName'] = platform.node()

    # Memory (RAM) - Fetching memory information
    memory = psutil.virtual_memory()
    # Memory (RAM) - This is used to convert bytes to gigabytes with two decimal places
    systemInfo['totalRam'] = f"{memory.total / (1024 ** 3):.2f} GB"
    systemInfo['availableRam'] = f"{memory.available / (1024 ** 3):.2f} GB"

    # Storage - Iterating through disk partitions
    partitions = psutil.disk_partitions()
    for partition in partitions:
        usage = psutil.disk_usage(partition.mountpoint)

        if os.name == 'nt':
            if 'fixed' in partition.opts or 'removable' in partition.opts:
                systemInfo['drive'] = partition.device
                systemInfo['totalStorage'] = f"{usage.total / (1024 ** 3):.2f} GB"
                systemInfo['freeStorage'] = f"{usage.free / (1024 ** 3):.2f} GB"
                systemInfo['driveType'] = 'HDD' if 'fixed' in partition.opts else 'SSD'
                break
        else:
            systemInfo['drive'] = partition.device
            systemInfo['totalStorage'] = f"{usage.total / (1024 ** 3):.2f} GB"
            systemInfo['freeStorage'] = f"{usage.free / (1024 ** 3):.2f} GB"

    # Graphics Card - Fetching GPU information

    if os.name == 'nt':
        import wmi
        w = wmi.WMI()
        for gpu in w.Win32_VideoController():
            systemInfo['graphicsCard'] = gpu.Name
            break

        gpuList = GPUtil.getGPUs()
        # Get Total Graphic Card Memory
        for gpu in gpuList:
            systemInfo["totalGraphicsMemory"] = f"{gpu.memoryTotal / 1000:.2f} GB"
            break

    # Network Information - Fetching network details
    systemInfo['subnetMask'] = socket.inet_ntoa(
        struct.pack('<L', (0xffffffff << (32 - 24)) & 0xffffffff))
    systemInfo['gateway'] = socket.gethostbyname(socket.getfqdn())
    systemInfo['dnsServers'] = ', '.join(socket.gethostbyname_ex(socket.gethostname())[2])

    return systemInfo


def writeToCSV(filePath, data):
    fieldnames = data.keys()
    with open(filePath, 'a', newline='') as csvfile:
        writer = csv.DictWriter(csvfile, fieldnames=fieldnames)
        writer.writerow(data)


def checkDataDiscrepancy(filePath, data):
    if os.path.exists(filePath):
        with open(filePath, 'r', newline='') as csvfile:
            reader = csv.DictReader(csvfile)
            for row in reader:
                for key, value in row.items():
                    if key in data and data[key] != value:
                        print(
                            f"Data discrepancy found for {key}: existing value '{value}', current value '{data[key]}'")
                        # You can raise an alert or handle the discrepancy as needed


if __name__ == "__main__":
    csvFilePath = "system_info.csv"

    # Check if CSV file exists, if not, create it with headers
    if not os.path.exists(csvFilePath):
        with open(csvFilePath, 'w', newline='') as csvfileheaders:
            fieldnamesHeader = ['systemTime', 'computerName', 'totalRam', 'availableRam', 'drive',
                                'totalStorage', 'freeStorage', 'driveType', 'graphicsCard',
                                'totalGraphicsMemory', 'subnetMask', 'gateway', 'dnsServers']
            newwriter = csv.DictWriter(csvfileheaders, fieldnames=fieldnamesHeader)
            newwriter.writeheader()

    systemInformation = getSystemInfo()
    # Check for data discrepancy
    checkDataDiscrepancy(csvFilePath, systemInformation)
    # Write to CSV file
    writeToCSV(csvFilePath, systemInformation)

    print("System information has been collected and stored in", csvFilePath)
