<?php

namespace Database\Seeders;

use App\Models\ExamPracticeSet;
use Illuminate\Database\Seeder;

class ExamPracticeSeeder extends Seeder
{
    public function run(): void
    {
        $set = ExamPracticeSet::query()->updateOrCreate(
            ['slug' => 'aws-cloud-practitioner-set-1'],
            [
                'title' => 'AWS Cloud Practitioner Set 1',
                'description' => 'Starter exam practice set for AWS Cloud Practitioner review.',
                'exam_code' => 'CLF-C02',
                'question_count' => 430,
                'is_published' => true,
            ],
        );

        $set->questions()->delete();

        $set->questions()->create([
            'question' => 'A web developer wants to use machine learning to classify images that are uploaded to a website. Which AWS service or feature will meet these requirements?',
            'options' => [
                'Amazon Rekognition',
                'Amazon SageMaker Clarify',
                'Amazon Mechanical Turk',
                'Amazon Transcribe',
            ],
            'correct_answer' => 'Amazon Rekognition',
            'explanation' => 'Amazon Rekognition provides prebuilt image and video analysis capabilities, including image classification.',
            'sort_order' => 1,
        ]);

        $set->questions()->create([
            'question' => 'A company is migrating a workload to AWS. The company needs the AWS Support team to respond to business-critical issues in 30 minutes or less. Which AWS Support plan will meet this requirement?',
            'options' => [
                'AWS Enterprise Support',
                'AWS Business Support',
                'AWS Basic Support',
                'AWS Developer Support',
            ],
            'correct_answer' => 'AWS Enterprise Support',
            'explanation' => 'AWS Enterprise Support is designed for mission-critical workloads and includes a 30-minute response target for business-critical issues.',
            'sort_order' => 2,
        ]);

        $set->questions()->create([
            'question' => 'Where can users find examples of AWS Cloud solution designs?',
            'options' => [
                'AWS Marketplace',
                'AWS Service Catalog',
                'AWS Architecture Center',
                'AWS Trusted Advisor',
            ],
            'correct_answer' => 'AWS Architecture Center',
            'explanation' => 'AWS Architecture Center provides reference architecture diagrams, solution ideas, and design guidance for AWS workloads.',
            'sort_order' => 3,
        ]);

        $set->questions()->create([
            'question' => 'Why are AWS CloudFormation templates used?',
            'options' => [
                'To reduce provisioning time by using automation.',
                'To transfer existing infrastructure to another company.',
                'To reuse on-premises infrastructure in the AWS Cloud.',
                'To deploy large infrastructure with no cost implications.',
            ],
            'correct_answer' => 'To reduce provisioning time by using automation.',
            'explanation' => 'Answer: A. To reduce provisioning time by using automation.',
            'sort_order' => 4,
        ]);

        $set->questions()->create([
            'question' => 'A company\'s workload can recover with minimal downtime when failures occur. Which AWS Cloud benefit does this scenario represent?',
            'options' => [
                'Agility',
                'Elasticity',
                'Resiliency',
                'Scalability',
            ],
            'correct_answer' => 'Resiliency',
            'explanation' => 'Resiliency is the ability of a system to recover quickly from failures and continue operating with minimal downtime or impact. AWS supports this through automated backups, failover capabilities, and redundant architecture.',
            'sort_order' => 5,
        ]);

        $set->questions()->create([
            'question' => 'A company plans to move its test workloads to Amazon EC2. The test workloads can be interrupted and are not required to start at a particular time. Which EC2 instance purchasing option is MOST cost-effective for this use case?',
            'options' => [
                'On-Demand Instances',
                'Spot Instances',
                'Reserved Instances',
                'Dedicated Hosts',
            ],
            'correct_answer' => 'Spot Instances',
            'explanation' => 'Spot Instances are suitable for workloads that can tolerate interruptions. They use unused EC2 capacity and can be much cheaper than On-Demand Instances, so they are ideal for test workloads.',
            'sort_order' => 6,
        ]);

        $set->questions()->create([
            'question' => 'Which AWS service or feature supports governance, compliance, and risk auditing of AWS accounts?',
            'options' => [
                'Multi-factor authentication (MFA)',
                'AWS Lambda',
                'Amazon Simple Notification Service (Amazon SNS)',
                'AWS CloudTrail',
            ],
            'correct_answer' => 'AWS CloudTrail',
            'explanation' => 'AWS CloudTrail helps support governance, compliance, and risk auditing by recording account activity and API events across AWS accounts.',
            'sort_order' => 7,
        ]);

        $set->questions()->create([
            'question' => 'A company needs to manage multiple logins across AWS accounts within the same organization in AWS Organizations. Which AWS service should the company use to meet this requirement?',
            'options' => [
                'Amazon VPC',
                'Amazon GuardDuty',
                'Amazon Cognito',
                'AWS IAM Identity Center',
            ],
            'correct_answer' => 'AWS IAM Identity Center',
            'explanation' => 'AWS IAM Identity Center provides centralized access management so users can sign in across multiple AWS accounts in an organization.',
            'sort_order' => 8,
        ]);

        $set->questions()->create([
            'question' => 'An AWS user wants to proactively detect when an instance or account might be compromised or if there are threats from attacks. Which AWS service should the user choose?',
            'options' => [
                'Amazon GuardDuty',
                'AWS WAF',
                'AWS Shield',
                'Amazon Inspector',
            ],
            'correct_answer' => 'Amazon GuardDuty',
            'explanation' => 'Amazon GuardDuty continuously monitors AWS accounts and workloads for malicious activity and potential threats.',
            'sort_order' => 9,
        ]);

        $set->questions()->create([
            'question' => 'An administrator observed that multiple AWS resources were deleted yesterday. Which AWS service will help identify the cause and determine which user deleted the resources?',
            'options' => [
                'AWS CloudTrail',
                'Amazon Inspector',
                'Amazon GuardDuty',
                'AWS Trusted Advisor',
            ],
            'correct_answer' => 'AWS CloudTrail',
            'explanation' => 'AWS CloudTrail records account activity and API events, including which user performed an action and when it occurred.',
            'sort_order' => 10,
        ]);

        $set->questions()->create([
            'question' => 'Which tasks are the responsibility of AWS according to the AWS shared responsibility model? (Choose two.)',
            'options' => [
                'Configure AWS Identity and Access Management (IAM).',
                'Configure security groups on Amazon EC2 instances.',
                'Secure the access of physical AWS facilities.',
                'Patch applications that run on Amazon EC2 instances.',
                'Perform infrastructure patching and maintenance.',
            ],
            'correct_answer' => '[2,4]',
            'explanation' => 'AWS is responsible for the physical security of its facilities and for patching and maintaining the underlying infrastructure. Customers are responsible for IAM, security groups, and the operating systems and applications running on Amazon EC2 instances.',
            'sort_order' => 11,
        ]);

        $set->questions()->create([
            'question' => 'A company needs an automated vulnerability management service that continually scans AWS workloads for software vulnerabilities. Which AWS service will meet these requirements?',
            'options' => [
                'Amazon GuardDuty',
                'Amazon Inspector',
                'AWS Security Hub',
                'AWS Shield',
            ],
            'correct_answer' => 'Amazon Inspector',
            'explanation' => 'Amazon Inspector continuously scans AWS workloads for software vulnerabilities and unintended network exposure. It can provide findings for EC2 instances and container images.',
            'sort_order' => 12,
        ]);

        $set->questions()->create([
            'question' => 'A company purchased Amazon EC2 Standard Reserved Instances (RIs) for an AWS workload. The company needs to move part of the workload to an instance family that does not match the instance family of these Standard RIs. How can the company take advantage of the Standard RIs that it no longer needs?',
            'options' => [
                'Contact the AWS Support team and ask the team to sell the Standard RIs.',
                'Sell the Standard RIs on the Amazon EC2 Reserved Instance Marketplace.',
                'Sell the Standard RIs as a third-party seller on AWS Marketplace.',
                'Convert the Standard RIs to Savings Plans.',
            ],
            'correct_answer' => 'Sell the Standard RIs on the Amazon EC2 Reserved Instance Marketplace.',
            'explanation' => 'Standard Reserved Instances can be sold on the Amazon EC2 Reserved Instance Marketplace when they are no longer needed.',
            'sort_order' => 13,
        ]);

        $set->questions()->create([
            'question' => 'A company wants to set up a secure network connection from on premises to the AWS Cloud within 1 week. Which solution will meet these requirements?',
            'options' => [
                'AWS Direct Connect',
                'Amazon VPC',
                'AWS Site-to-Site VPN',
                'Edge location',
            ],
            'correct_answer' => 'AWS Site-to-Site VPN',
            'explanation' => 'AWS Site-to-Site VPN can be provisioned quickly and provides a secure connection from on-premises environments to AWS.',
            'sort_order' => 14,
        ]);

        $set->questions()->create([
            'question' => 'A company is migrating an application to AWS. As part of the migration, the company needs to move the application\'s database to Amazon RDS. Which AWS service should the company use to migrate the database?',
            'options' => [
                'AWS Database Migration Service (AWS DMS)',
                'AWS Application Migration Service',
                'AWS Migration Hub',
                'Migration Evaluator',
            ],
            'correct_answer' => 'AWS Database Migration Service (AWS DMS)',
            'explanation' => 'AWS DMS is designed to migrate databases to AWS. It supports both homogeneous and heterogeneous migrations while helping reduce downtime.',
            'sort_order' => 15,
        ]);

        $set->questions()->create([
            'question' => 'Which AWS Well-Architected Framework pillar focuses on structured and streamlined allocation of computing resources?',
            'options' => [
                'Reliability',
                'Operational excellence',
                'Performance efficiency',
                'Sustainability',
            ],
            'correct_answer' => 'Performance efficiency',
            'explanation' => 'The Performance Efficiency pillar focuses on using computing resources efficiently and maintaining that efficiency as demand changes.',
            'sort_order' => 16,
        ]);

        $set->questions()->create([
            'question' => 'A company wants to rightsize its Amazon EC2 instances. Which configuration change will meet this requirement with the LEAST operational overhead?',
            'options' => [
                'Add EC2 instances in another Availability Zone.',
                'Change the size and type of the EC2 instances based on utilization.',
                'Convert the payment method from On-Demand to Savings Plans.',
                'Reprovision the EC2 instances with a larger instance type.',
            ],
            'correct_answer' => 'Change the size and type of the EC2 instances based on utilization.',
            'explanation' => 'Rightsizing means choosing instance sizes and families that better match actual utilization with minimal unnecessary overhead or cost.',
            'sort_order' => 17,
        ]);

        $set->questions()->create([
            'question' => 'A company wants to run its workload on Amazon EC2 instances for more than 1 year. This workload will run continuously. Which option offers a discounted hourly rate compared to the hourly rate of On-Demand Instances?',
            'options' => [
                'AWS Graviton processor',
                'Dedicated Hosts',
                'EC2 Instance Savings Plans',
                'Amazon EC2 Auto Scaling instances',
            ],
            'correct_answer' => 'EC2 Instance Savings Plans',
            'explanation' => 'EC2 Instance Savings Plans offer lower hourly rates than On-Demand pricing for steady long-term usage commitments.',
            'sort_order' => 18,
        ]);

        $set->questions()->create([
            'question' => 'A company uses Amazon RDS for a product database. The company wants to ensure the database is highly available. Which feature of Amazon RDS will meet this requirement?',
            'options' => [
                'Read replicas',
                'Blue/green deployment',
                'Multi-AZ deployment',
                'Reserved Instances',
            ],
            'correct_answer' => 'Multi-AZ deployment',
            'explanation' => 'Multi-AZ deployment improves availability and durability by maintaining a synchronous standby instance in another Availability Zone.',
            'sort_order' => 19,
        ]);

        $set->questions()->create([
            'question' => 'A company is planning a migration to AWS. The company wants to modernize its applications by refactoring the applications to microservices. Which AWS service or feature should the company use to achieve this goal?',
            'options' => [
                'AWS Migration Hub Refactor Spaces',
                'AWS Application Migration Service',
                'AWS Database Migration Service (AWS DMS)',
                'AWS Compute Optimizer',
            ],
            'correct_answer' => 'AWS Migration Hub Refactor Spaces',
            'explanation' => 'AWS Migration Hub Refactor Spaces helps companies modernize applications by gradually refactoring them into microservices and managing the transition process.',
            'sort_order' => 20,
        ]);

        $set->questions()->create([
            'question' => 'A company wants to run relational databases in the AWS Cloud. The company wants to use a managed service that will install the database and run regular software updates. Which AWS service will meet these requirements?',
            'options' => [
                'Amazon S3',
                'Amazon RDS',
                'Amazon Elastic Block Store (Amazon EBS)',
                'Amazon DynamoDB',
            ],
            'correct_answer' => 'Amazon RDS',
            'explanation' => 'Amazon RDS is a managed relational database service. AWS handles software installation, patching, backups, and routine maintenance.',
            'sort_order' => 21,
        ]);

        $set->questions()->create([
            'question' => 'A company needs a threat detection service that will continuously monitor its AWS accounts, workloads, and Amazon S3 buckets for malicious activity and unauthorized behavior. Which AWS service meets these requirements?',
            'options' => [
                'AWS Shield',
                'AWS Firewall Manager',
                'Amazon GuardDuty',
                'Amazon Inspector',
            ],
            'correct_answer' => 'Amazon GuardDuty',
            'explanation' => 'Amazon GuardDuty continuously monitors AWS accounts, workloads, and S3 buckets to detect suspicious activity and potential threats.',
            'sort_order' => 22,
        ]);

        $set->questions()->create([
            'question' => 'Which AWS service gives users the ability to deploy highly repeatable infrastructure configurations?',
            'options' => [
                'AWS CloudFormation',
                'AWS CodeDeploy',
                'AWS CodeBuild',
                'AWS Systems Manager',
            ],
            'correct_answer' => 'AWS CloudFormation',
            'explanation' => 'AWS CloudFormation uses Infrastructure as Code (IaC) templates to automate and repeatedly deploy AWS resources consistently.',
            'sort_order' => 23,
        ]);

        $set->questions()->create([
            'question' => 'Which benefit of cloud computing gives a company the ability to deploy applications to users all over the world through a network of AWS Regions, Availability Zones, and edge locations?',
            'options' => [
                'Economy of scale',
                'Global reach',
                'Agility',
                'High availability',
            ],
            'correct_answer' => 'Global reach',
            'explanation' => 'AWS Global Infrastructure enables applications to be deployed worldwide by using Regions, Availability Zones, and edge locations.',
            'sort_order' => 24,
        ]);

        $set->questions()->create([
            'question' => 'A company owns per-core software licenses. Which Amazon EC2 instance purchasing option must the company use for this license type?',
            'options' => [
                'Reserved Instances',
                'Dedicated Hosts',
                'Spot Instances',
                'Dedicated Instances',
            ],
            'correct_answer' => 'Dedicated Hosts',
            'explanation' => 'Dedicated Hosts provide physical servers dedicated to a single customer, allowing the use of existing per-core software licenses while meeting licensing and compliance requirements.',
            'sort_order' => 25,
        ]);

                $set->questions()->create([
            'question' => 'Under the AWS shared responsibility model, which of the following is a responsibility of the customer?',
            'options' => [
                'Shred disk drives before they leave a data center.',
                'Prevent customers from gathering packets or collecting traffic at the hypervisor level.',
                'Patch the guest operating system with the latest security patches.',
                'Maintain security systems that provide physical monitoring of data centers.',
            ],
            'correct_answer' => 'Patch the guest operating system with the latest security patches.',
            'explanation' => 'Under the AWS Shared Responsibility Model, customers are responsible for the security in the cloud. This includes patching and maintaining the guest operating system, installed software, and applications running on Amazon EC2 instances. AWS is responsible for securing the underlying infrastructure, including physical data centers, hardware, networking, and the hypervisor.',
            'sort_order' => 26,
        ]);

        $set->questions()->create([
            'question' => 'What is a customer responsibility under the AWS shared responsibility model when using AWS Lambda?',
            'options' => [
                'Maintenance of the underlying Lambda hardware.',
                'Maintenance of the Lambda networking infrastructure.',
                'The code and libraries that run in the Lambda functions.',
                'The Lambda server software.',
            ],
            'correct_answer' => 'The code and libraries that run in the Lambda functions.',
            'explanation' => 'Answer: C. Reference: https://docs.aws.amazon.com/whitepapers/latest/security-overview-aws-lambda/the-shared-responsibility-model.html',
            'sort_order' => 27,
        ]);

        $set->questions()->create([
            'question' => 'A company has an application that uses Amazon DynamoDB for data storage. Which task is the responsibility of AWS, according to the AWS shared responsibility model?',
            'options' => [
                'Define who or what can read data in a table.',
                'Encrypt user data at rest.',
                'Implement client-side encryption.',
                'Prevent the storage of sensitive data in a table.',
            ],
            'correct_answer' => 'Encrypt user data at rest.',
            'explanation' => 'Answer: B',
            'sort_order' => 28,
        ]);

        $set->questions()->create([
            'question' => 'Which AWS service or tool will monitor AWS resources and applications in real time?',
            'options' => [
                'AWS Trusted Advisor',
                'Amazon CloudWatch',
                'AWS CloudTrail',
                'AWS Cost Explorer',
            ],
            'correct_answer' => 'Amazon CloudWatch',
            'explanation' => 'Answer: B',
            'sort_order' => 29,
        ]);

        $set->questions()->create([
            'question' => 'A company wants to use a managed service to identify and protect sensitive data that is stored in Amazon S3. Which AWS service will meet these requirements?',
            'options' => [
                'AWS IAM Access Analyzer',
                'Amazon GuardDuty',
                'Amazon Inspector',
                'Amazon Macie',
            ],
            'correct_answer' => 'Amazon Macie',
            'explanation' => 'Answer: D',
            'sort_order' => 30,
        ]);

        $set->questions()->create([
            'question' => 'A company wants to automatically add subtitles to its web-based live radio application. Which AWS service will meet this requirement?',
            'options' => [
                'Amazon Augmented AI (Amazon A2I)',
                'Amazon Monitron',
                'Amazon Textract',
                'Amazon Transcribe',
            ],
            'correct_answer' => 'Amazon Transcribe',
            'explanation' => 'Answer: D',
            'sort_order' => 31,
        ]);

        $set->questions()->create([
            'question' => 'A company needs to use Amazon EC2 instances to conduct quality assurance tests. The EC2 instances must run continuously without interruption for 1 month. After 1 month, the company will not need the EC2 instances anymore. Which EC2 instance purchasing option will meet these requirements MOST cost-effectively?',
            'options' => [
                'Dedicated Hosts',
                'On-Demand Instances',
                'Reserved Instances',
                'Spot Instances',
            ],
            'correct_answer' => 'On-Demand Instances',
            'explanation' => 'Answer: B',
            'sort_order' => 32,
        ]);

        $set->questions()->create([
            'question' => 'A company is running a reporting web server application on Amazon EC2 instances. The application runs once every week and once again at the end of the month. The EC2 instances can be shut down when they are not in use. What is the MOST cost-effective billing model for this use case?',
            'options' => [
                'Standard Reserved Instances',
                'Convertible Reserved Instances',
                'On-Demand Capacity Reservations',
                'On-Demand Instances',
            ],
            'correct_answer' => 'On-Demand Instances',
            'explanation' => 'Answer: D',
            'sort_order' => 33,
        ]);

        $set->questions()->create([
            'question' => 'A company wants to use machine learning to identify suspicious activities in its AWS account. Which AWS service provides this functionality?',
            'options' => [
                'AWS Shield',
                'Amazon Macie',
                'Amazon Detective',
                'AWS WAF',
            ],
            'correct_answer' => 'Amazon Detective',
            'explanation' => 'Answer: C',
            'sort_order' => 34,
        ]);

        $set->questions()->create([
            'question' => 'Which AWS service or feature can a company use to create a private, secured, and scalable network environment in the AWS Cloud?',
            'options' => [
                'Amazon Elastic Container Service (Amazon ECS)',
                'Amazon S3',
                'Amazon VPC',
                'Route tables',
            ],
            'correct_answer' => 'Amazon VPC',
            'explanation' => 'Answer: C',
            'sort_order' => 35,
        ]);
        $set->questions()->create([
            'question' => 'A company needs the ability to restore objects in an Amazon S3 bucket if the objects are accidentally overwritten. Which solution will meet this requirement MOST cost-effectively?',
            'options' => [
                'Back up the objects by using AWS Backup.',
                'Enable S3 Versioning.',
                'Maintain a copy of the objects in another S3 bucket.',
                'Replicate the objects to different AWS Regions.',
            ],
            'correct_answer' => 'Enable S3 Versioning.',
            'explanation' => 'S3 Versioning keeps multiple versions of an object so overwritten or deleted objects can be restored cost-effectively.',
            'sort_order' => 36,
        ]);

        $set->questions()->create([
            'question' => 'A company is connecting multiple VPCs and on-premises networks. The company needs to use an AWS service as a cloud router to simplify peering relationships. Which AWS service can the company use to meet this requirement?',
            'options' => [
                'AWS Direct Connect',
                'AWS Transit Gateway',
                'Amazon Connect',
                'Amazon Route 53',
            ],
            'correct_answer' => 'AWS Transit Gateway',
            'explanation' => 'AWS Transit Gateway acts as a central cloud router that connects multiple VPCs and on-premises networks.',
            'sort_order' => 37,
        ]);

        $set->questions()->create([
            'question' => 'According to the AWS shared responsibility model, which activities are the customer\'s responsibility for security in the AWS Cloud? (Choose two.)',
            'options' => [
                'Hardware maintenance',
                'Amazon EC2 operating system patching',
                'API access control for AWS resources',
                'Configuration management of infrastructure devices',
                'Maintenance of an Availability Zone',
            ],
            'correct_answer' => '[1,2]',
            'explanation' => 'Answer: B, C',
            'sort_order' => 38,
        ]);

        $set->questions()->create([
            'question' => 'A company needs to gain data insights by using natural language to ask questions about its data. Which AWS service provides this functionality?',
            'options' => [
                'AWS Glue',
                'Amazon SageMaker',
                'Amazon QuickSight',
                'AWS Panorama',
            ],
            'correct_answer' => 'Amazon QuickSight',
            'explanation' => 'Amazon QuickSight provides business intelligence capabilities, including natural language queries for data insights.',
            'sort_order' => 39,
        ]);

        $set->questions()->create([
            'question' => 'A company notices suspicious network activity against an application that is running on a fleet of Amazon EC2 instances. The suspicious activity is coming from a single IP address. Which AWS service should the company use to block access from this IP address?',
            'options' => [
                'AWS Shield',
                'AWS Config',
                'Amazon GuardDuty',
                'AWS WAF',
            ],
            'correct_answer' => 'AWS WAF',
            'explanation' => 'AWS WAF can block requests from specific IP addresses by using IP match rules in a web ACL.',
            'sort_order' => 40,
        ]);
        $set->questions()->create([
            'question' => 'A company needs to bridge between technology and business to help evolve to a culture of continuous growth and learning. Which perspective in the AWS Cloud Adoption Framework (AWS CAF) serves as this bridge?',
            'options' => [
                'People',
                'Governance',
                'Operations',
                'Security',
            ],
            'correct_answer' => 'People',
            'explanation' => 'In AWS CAF, the People perspective helps bridge technology and business by focusing on organizational change, culture, skills, and continuous learning.',
            'sort_order' => 41,
        ]);

        $set->questions()->create([
            'question' => 'A company needs stateless network filtering for its VPC. Which AWS service, tool, or feature will meet this requirement?',
            'options' => [
                'AWS PrivateLink',
                'Security group',
                'Network access control list (ACL)',
                'AWS WAF',
            ],
            'correct_answer' => 'Network access control list (ACL)',
            'explanation' => 'A network ACL provides stateless filtering at the subnet level in a VPC.',
            'sort_order' => 42,
        ]);

        $set->questions()->create([
            'question' => 'A company wants to build, train, and deploy machine learning (ML) models. Which AWS service can the company use to meet this requirement?',
            'options' => [
                'Amazon Personalize',
                'Amazon Comprehend',
                'Amazon Forecast',
                'Amazon SageMaker',
            ],
            'correct_answer' => 'Amazon SageMaker',
            'explanation' => 'Amazon SageMaker provides tools to build, train, and deploy machine learning models at scale.',
            'sort_order' => 43,
        ]);

        $set->questions()->create([
            'question' => 'Which AWS service gives users the ability to develop loosely coupled microservices and improve service-to-service communication?',
            'options' => [
                'AWS Elastic Beanstalk',
                'AWS Direct Connect',
                'Amazon EventBridge',
                'Amazon CloudWatch Logs',
            ],
            'correct_answer' => 'Amazon EventBridge',
            'explanation' => 'Amazon EventBridge supports event-driven architectures that help build loosely coupled microservices and improve service-to-service communication.',
            'sort_order' => 44,
        ]);

        $set->questions()->create([
            'question' => 'A company needs to store data across multiple Availability Zones in an AWS Region. The data will not be accessed regularly but must be immediately retrievable. Which Amazon Elastic File System (Amazon EFS) storage class meets these requirements MOST cost-effectively?',
            'options' => [
                'EFS Standard',
                'EFS Standard-Infrequent Access (EFS Standard-IA)',
                'EFS One Zone',
                'EFS One Zone-Infrequent Access (EFS One Zone-IA)',
            ],
            'correct_answer' => 'EFS Standard-Infrequent Access (EFS Standard-IA)',
            'explanation' => 'EFS Standard-IA stores data across multiple Availability Zones, costs less for infrequently accessed files, and still allows immediate retrieval.',
            'sort_order' => 45,
        ]);
        $set->questions()->create([
            'question' => 'A company needs to create and manage a portfolio of IT workloads that the company approves for use on AWS. Which AWS service provides this functionality?',
            'options' => [
                'AWS Config',
                'AWS Service Catalog',
                'AWS Systems Manager',
                'AWS CloudFormation',
            ],
            'correct_answer' => 'AWS Service Catalog',
            'explanation' => 'AWS Service Catalog enables organizations to create, manage, and distribute a portfolio of approved IT services and workloads on AWS. It ensures compliance and consistency by allowing administrators to control which products and configurations are available to users, such as virtual machine images, databases, and application stacks.',
            'sort_order' => 46,
        ]);

        $set->questions()->create([
            'question' => 'A company wants to reduce the cost of its Amazon EC2 instances. The applications that run on the instances cannot tolerate interruptions. The instances must remain in operation for at least 1 year. Which purchasing options should the company use to meet these requirements? (Choose two.)',
            'options' => [
                'Reserved Instances',
                'Spot Instances',
                'AWS Marketplace subscriptions',
                'Savings Plans',
                'Dedicated Hosts',
            ],
            'correct_answer' => '[0,3]',
            'explanation' => 'Answer: A, D',
            'sort_order' => 47,
        ]);

        $set->questions()->create([
            'question' => 'A company needs to migrate data directly from another cloud service provider\'s environment to AWS. Which AWS service will meet this requirement?',
            'options' => [
                'AWS Snowcone',
                'AWS Global Accelerator',
                'AWS Fargate',
                'AWS DataSync',
            ],
            'correct_answer' => 'AWS DataSync',
            'explanation' => 'AWS DataSync is a data migration service designed to automate moving data between on-premises storage systems, cloud storage, or other cloud service providers directly to AWS services such as Amazon S3, Amazon EFS, or Amazon FSx. It is specifically built to handle large-scale data transfers efficiently and securely.',
            'sort_order' => 48,
        ]);

        $set->questions()->create([
            'question' => 'A company is hosting a web application on Amazon EC2 instances. The company wants to implement custom conditions to filter and control inbound web traffic. Which AWS service will meet these requirements?',
            'options' => [
                'Amazon GuardDuty',
                'AWS WAF',
                'Amazon Macie',
                'AWS Shield',
            ],
            'correct_answer' => 'AWS WAF',
            'explanation' => 'Answer: B',
            'sort_order' => 49,
        ]);

        $set->questions()->create([
            'question' => 'Which AWS service or feature provides trusted users with temporary security credentials to access AWS resources?',
            'options' => [
                'AWS Control Tower',
                'IAM user',
                'IAM web identity federation',
                'AWS Security Token Service (AWS STS)',
            ],
            'correct_answer' => 'AWS Security Token Service (AWS STS)',
            'explanation' => 'AWS Security Token Service (AWS STS) provides temporary security credentials for trusted users or applications to access AWS resources. These credentials are short-lived and can be used for scenarios like federated user access, cross-account access, and role assumption, enhancing security and flexibility.',
            'sort_order' => 50,
        ]);

        $set->questions()->create([
            'question' => 'A company wants to automatically patch its Windows instances that are deployed on Amazon EC2. Which AWS service will meet these requirements?',
            'options' => [
                'AWS Systems Manager',
                'AWS Organizations',
                'AWS Control Tower',
                'Elastic Load Balancing (ELB)',
            ],
            'correct_answer' => 'AWS Systems Manager',
            'explanation' => 'AWS Systems Manager provides tools to manage and automate tasks for Amazon EC2 instances, including patch management. With Systems Manager Patch Manager, a company can automatically patch Windows instances and keep them up to date with the latest security and system updates.',
            'sort_order' => 51,
        ]);

        $set->questions()->create([
            'question' => 'Which AWS service provides serverless compute for use with containers?',
            'options' => [
                'Amazon Simple Queue Service (Amazon SQS)',
                'AWS Fargate',
                'AWS Elastic Beanstalk',
                'Amazon SageMaker',
            ],
            'correct_answer' => 'AWS Fargate',
            'explanation' => 'Answer: B',
            'sort_order' => 52,
        ]);

        $set->questions()->create([
            'question' => 'For which use case are Amazon EC2 On-Demand Instances MOST cost-effective?',
            'options' => [
                'Compute-intensive video transcoding that can be restarted if necessary',
                'An instance in continual use for 1 month to conduct quality assurance tests',
                'An instance that runs a web server that will run for 1 year',
                'An instance that runs a database that will run for 3 years',
            ],
            'correct_answer' => 'An instance in continual use for 1 month to conduct quality assurance tests',
            'explanation' => 'Answer: B',
            'sort_order' => 53,
        ]);

        $set->questions()->create([
            'question' => 'An ecommerce company has deployed a new web application on Amazon EC2 instances. The company wants to distribute incoming HTTP traffic evenly across all running instances. Which AWS service or resource will meet this requirement?',
            'options' => [
                'Amazon EC2 Auto Scaling',
                'Application Load Balancer',
                'Gateway Load Balancer',
                'Network Load Balancer',
            ],
            'correct_answer' => 'Application Load Balancer',
            'explanation' => 'Answer: B',
            'sort_order' => 54,
        ]);

        $set->questions()->create([
            'question' => 'A company has only basic knowledge of AWS technologies. Which AWS service provides the SIMPLEST way for the company to establish a website on AWS?',
            'options' => [
                'Amazon Elastic File System (Amazon EFS)',
                'AWS Elastic Beanstalk',
                'AWS Lambda',
                'Amazon Lightsail',
            ],
            'correct_answer' => 'Amazon Lightsail',
            'explanation' => 'Answer: D',
            'sort_order' => 55,
        ]);

        $set->questions()->create([
            'question' => 'A company\'s user base needs to remotely access virtual desktop computers from the internet. Which AWS service provides this functionality?',
            'options' => [
                'Amazon Connect',
                'Amazon Cognito',
                'Amazon WorkSpaces',
                'Amazon AppStream 2.0',
            ],
            'correct_answer' => 'Amazon WorkSpaces',
            'explanation' => 'Answer: C',
            'sort_order' => 56,
        ]);

        $set->questions()->create([
            'question' => 'A financial company needs to centrally manage its AWS accounts and use consolidated billing. Which AWS service or feature should the company use?',
            'options' => [
                'AWS Cost Explorer',
                'AWS Organizations',
                'AWS Billing and Cost Management',
                'AWS Budgets',
            ],
            'correct_answer' => 'AWS Organizations',
            'explanation' => 'AWS Organizations lets companies centrally manage multiple AWS accounts and use consolidated billing under one billing structure.',
            'sort_order' => 57,
        ]);

        $set->questions()->create([
            'question' => 'Which AWS service, feature, or tool uses machine learning to continuously monitor cost and usage for unusual cloud spending?',
            'options' => [
                'Amazon Lookout for Metrics',
                'AWS Budgets',
                'Amazon CloudWatch',
                'AWS Cost Anomaly Detection',
            ],
            'correct_answer' => 'AWS Cost Anomaly Detection',
            'explanation' => 'AWS Cost Anomaly Detection uses machine learning to continuously monitor cost and usage patterns for unusual spending and helps identify unexpected cloud cost changes.',
            'sort_order' => 58,
        ]);

        $set->questions()->create([
            'question' => 'A company needs to configure its AWS services by using a web-based application. Which AWS offering will meet this requirement?',
            'options' => [
                'AWS CLI',
                'AWS Management Console',
                'AWS Marketplace',
                'AWS SDKs',
            ],
            'correct_answer' => 'AWS Management Console',
            'explanation' => 'The AWS Management Console is a web-based application that provides a graphical interface for configuring, managing, and monitoring AWS services through a browser.',
            'sort_order' => 59,
        ]);

        $set->questions()->create([
            'question' => 'Which AWS Cloud deployment model uses AWS Outposts as part of the application deployment infrastructure?',
            'options' => [
                'On-premises',
                'Serverless',
                'Cloud-native',
                'Hybrid',
            ],
            'correct_answer' => 'Hybrid',
            'explanation' => 'AWS Outposts is used in a hybrid cloud deployment model because it extends AWS infrastructure, services, APIs, and tools to on-premises environments.',
            'sort_order' => 60,
        ]);

        $set->questions()->create([
            'question' => 'Which AWS service can identify activities in images and videos and detect any inappropriate content?',
            'options' => [
                'Amazon Comprehend',
                'Amazon QuickSight',
                'Amazon Rekognition',
                'Amazon Personalize',
            ],
            'correct_answer' => 'Amazon Rekognition',
            'explanation' => 'Amazon Rekognition is a deep learning-based image and video analysis service that can identify objects, scenes, and activities and can detect inappropriate content.',
            'sort_order' => 61,
        ]);

        $set->questions()->create([
            'question' => 'Which AWS solution gives companies the ability to use protocols such as NFS to store and retrieve objects in Amazon S3?',
            'options' => [
                'Amazon FSx for Lustre',
                'AWS Storage Gateway volume gateway',
                'AWS Storage Gateway file gateway',
                'Amazon Elastic File System (Amazon EFS)',
            ],
            'correct_answer' => 'AWS Storage Gateway file gateway',
            'explanation' => 'AWS Storage Gateway file gateway provides file-based access by using protocols such as NFS and SMB while storing objects in Amazon S3.',
            'sort_order' => 62,
        ]);

        $set->questions()->create([
            'question' => 'Which of the following are benefits of Amazon EC2 Auto Scaling? (Choose two.)',
            'options' => [
                'Improved health and availability of applications',
                'Reduced network latency',
                'Optimized performance and costs',
                'Automated snapshots of data',
                'Cross-Region Replication',
            ],
            'correct_answer' => '[0,2]',
            'explanation' => 'Amazon EC2 Auto Scaling improves application health and availability by replacing unhealthy instances automatically, and it optimizes performance and costs by adjusting capacity based on demand.',
            'sort_order' => 63,
        ]);

        $set->questions()->create([
            'question' => 'An ecommerce company wants to distribute traffic between the Amazon EC2 instances that host its website. Which AWS service or resource will meet these requirements?',
            'options' => [
                'Application Load Balancer',
                'AWS WAF',
                'AWS CloudHSM',
                'AWS Direct Connect',
            ],
            'correct_answer' => 'Application Load Balancer',
            'explanation' => 'Answer: A',
            'sort_order' => 64,
        ]);

        $set->questions()->create([
            'question' => 'A cloud engineer wants to know the percentage of the allocated compute units that are in use for a specific Amazon EC2 instance. Which AWS service can provide this information?',
            'options' => [
                'AWS CloudTrail',
                'AWS Config',
                'Amazon CloudWatch',
                'AWS Artifact',
            ],
            'correct_answer' => 'Amazon CloudWatch',
            'explanation' => 'Amazon CloudWatch provides monitoring and observability for AWS resources, including Amazon EC2 metrics such as CPU utilization and other performance data.',
            'sort_order' => 65,
        ]);

        $set->questions()->create([
            'question' => 'Question 66\n\nWhich AWS service can automate patching of operating systems that run on Amazon EC2 instances?',
            'options' => [
                'Amazon Inspector',
                'AWS License Manager',
                'AWS Config',
                'AWS Systems Manager',
            ],
            'correct_answer' => 'AWS Systems Manager',
            'explanation' => 'AWS Systems Manager provides a feature called Patch Manager, which automates the patching process for operating systems on Amazon EC2 instances. It helps ensure that systems are up-to-date with security and compliance requirements by automating updates for both Windows and Linux instances.',
            'sort_order' => 66,
        ]);

        $set->questions()->create([
            'question' => 'Question 67\n\nA company wants to migrate a company\'s on-premises container infrastructure to the AWS Cloud. The company wants to prevent unplanned administration and operation cost and adapt to a serverless architecture.\n\nWhich AWS service will meet these requirements?',
            'options' => [
                'Amazon Connect',
                'AWS Fargate',
                'Amazon Lightsail',
                'Amazon EC2',
            ],
            'correct_answer' => 'AWS Fargate',
            'explanation' => 'AWS Fargate is a serverless compute engine for containers. It allows companies to run containers without managing servers or infrastructure, helping reduce administration and operational overhead while supporting a serverless architecture.',
            'sort_order' => 67,
        ]);

        $set->questions()->create([
            'question' => 'Question 68\n\nA company has multiple SQL-based databases located in a data center. The company needs to migrate all database servers to the AWS Cloud to reduce the cost of operating physical servers.\n\nWhich AWS service or resource will meet these requirements with the LEAST operational overhead?',
            'options' => [
                'Amazon EC2 instances',
                'Amazon RDS',
                'Amazon DynamoDB',
                'OpenSearch',
            ],
            'correct_answer' => 'Amazon RDS',
            'explanation' => 'Amazon RDS is a fully managed relational database service that supports SQL-based databases. It reduces operational overhead by automating tasks such as hardware provisioning, patching, backups, and maintenance, making it the ideal choice for migrating SQL databases to AWS.',
            'sort_order' => 68,
        ]);

        $set->questions()->create([
            'question' => 'Question 69\n\nA company wants to gain insights from its data and build interactive data visualization dashboards.\n\nWhich AWS service will meet these requirements?',
            'options' => [
                'Amazon SageMaker',
                'Amazon Rekognition',
                'Amazon QuickSight',
                'Amazon Kinesis',
            ],
            'correct_answer' => 'Amazon QuickSight',
            'explanation' => 'Amazon QuickSight is a cloud-based business intelligence (BI) service that enables users to analyze data, gain insights, and create interactive dashboards and visualizations. It connects to various data sources and provides scalable, fast, and interactive reporting capabilities.',
            'sort_order' => 69,
        ]);

        $set->questions()->create([
            'question' => 'Question 70\n\nWhich AWS solution provides the ability for a company to run AWS services in the company\'s on-premises data center?',
            'options' => [
                'AWS Direct Connect',
                'AWS Outposts',
                'AWS Systems Manager hybrid activations',
                'AWS Storage Gateway',
            ],
            'correct_answer' => 'AWS Outposts',
            'explanation' => 'AWS Outposts extends AWS infrastructure, services, APIs, and tools to on-premises environments, allowing companies to run AWS services in their own data centers. This solution provides a hybrid cloud environment with consistent, low-latency access to AWS services while maintaining on-premises operations.',
            'sort_order' => 70,
        ]);

        $set->questions()->create([
            'question' => 'Question 71\n\nWhich AWS service will turn text into lifelike speech?',
            'options' => [
                'Amazon Polly',
                'Amazon Rekognition',
                'Amazon Connect',
                'Amazon Kendra',
            ],
            'correct_answer' => 'Amazon Polly',
            'explanation' => 'Amazon Polly is a text-to-speech (TTS) service that uses advanced deep learning technologies to convert text into natural-sounding speech. It supports multiple languages and voices, making it ideal for applications such as voice-enabled applications, IVR systems, and accessibility solutions.',
            'sort_order' => 71,
        ]);

        $set->questions()->create([
            'question' => 'Question 72\n\nA company needs to migrate a 3 TB file share from its on-premises data center to AWS. The company has a 10 Gbps AWS Direct Connect connection between the on-premises data center and AWS.\n\nWhich AWS service will migrate the data in the LEAST amount of time?',
            'options' => [
                'AWS DataSync',
                'AWS Snowcone',
                'AWS Snowball Edge',
                'AWS Migration Hub',
            ],
            'correct_answer' => 'AWS DataSync',
            'explanation' => 'AWS DataSync is designed for efficiently transferring large amounts of data over a high-speed network, such as a 10 Gbps AWS Direct Connect connection. It automates and accelerates data transfers between on-premises storage and AWS services like Amazon S3 or Amazon EFS. This makes it the fastest and most efficient option for migrating a 3 TB file share in this scenario.',
            'sort_order' => 72,
        ]);

        $set->questions()->create([
            'question' => 'Question 73\n\nWhich option routes inbound traffic from the internet to resources in a VPC?',
            'options' => [
                'AWS Fargate',
                'Internet gateway',
                'VPC peering connection',
                'AWS WAF',
            ],
            'correct_answer' => 'Internet gateway',
            'explanation' => 'An Internet Gateway is used to allow inbound traffic from the internet to reach resources in an Amazon VPC. It enables communication between instances in the VPC and the internet, providing the ability for publicly accessible resources (such as EC2 instances) to receive traffic from the internet.',
            'sort_order' => 73,
        ]);

        $set->questions()->create([
            'question' => 'Question 74\n\nA company wants a cost-effective option when running its applications in an Amazon EC2 instance for short time periods. The applications can be interrupted.\n\nWhich EC2 instance type will meet these requirements?',
            'options' => [
                'Spot Instances',
                'On-Demand Instances',
                'Reserved Instances',
                'Dedicated Instances',
            ],
            'correct_answer' => 'Spot Instances',
            'explanation' => 'Spot Instances provide unused Amazon EC2 capacity at significantly discounted prices. They are ideal for short-term, fault-tolerant, and interruptible workloads because AWS can reclaim the instances when capacity is needed. This makes Spot Instances the most cost-effective choice for applications that can be interrupted.',
            'sort_order' => 74,
        ]);

        $set->questions()->create([
            'question' => 'Question 75\n\nWhich AWS services can host PostgreSQL databases? (Choose two.)',
            'options' => [
                'Amazon S3',
                'Amazon Aurora',
                'Amazon EC2',
                'Amazon OpenSearch Service',
                'Amazon Elastic File System (Amazon EFS)',
            ],
            'correct_answer' => '[1,2]',
            'explanation' => 'Amazon Aurora supports PostgreSQL-compatible databases as a fully managed relational database service. Amazon EC2 can also host PostgreSQL by allowing users to install and manage the PostgreSQL database software on EC2 instances.',
            'sort_order' => 75,
        ]);

        $set->questions()->create([
            'question' => 'Question 76\n\nWhich AWS service supports user sign-up functionality and authentication to mobile and web applications?',
            'options' => [
                'Amazon Cognito',
                'AWS Config',
                'Amazon GuardDuty',
                'AWS Systems Manager',
            ],
            'correct_answer' => 'Amazon Cognito',
            'explanation' => 'Amazon Cognito provides user sign-up, sign-in, and authentication for web and mobile applications. It supports user identity management, authentication, authorization, and integration with social identity providers and enterprise identity providers.',
            'sort_order' => 76,
        ]);

        $set->questions()->create([
            'question' => 'Question 77\n\nWhich recommendation can AWS Cost Explorer provide to help reduce cost?',
            'options' => [
                'Use a specific database engine.',
                'Change the programming language for an application.',
                'Deploy a specific operating system.',
                'Terminate an idle instance.',
            ],
            'correct_answer' => 'Terminate an idle instance.',
            'explanation' => 'AWS Cost Explorer can provide cost optimization recommendations by identifying underutilized or idle resources. One common recommendation is to terminate idle instances to reduce unnecessary AWS costs.',
            'sort_order' => 77,
        ]);

        $set->questions()->create([
            'question' => 'Question 78\n\nWhich AWS service or feature can be used to monitor for potential disk write spikes on a system that is running on Amazon EC2?',
            'options' => [
                'AWS CloudTrail',
                'AWS Health Dashboard',
                'AWS Trusted Advisor',
                'Amazon CloudWatch',
            ],
            'correct_answer' => 'Amazon CloudWatch',
            'explanation' => 'Amazon CloudWatch monitors Amazon EC2 instances and collects performance metrics such as disk read/write operations, CPU utilization, network traffic, and memory usage (with the CloudWatch agent). It can detect potential disk write spikes and trigger alarms when configured with CloudWatch metrics and alarms.',
            'sort_order' => 78,
        ]);

        $set->questions()->create([
            'question' => 'Question 79\n\nA company wants to migrate its applications to the AWS Cloud. The company plans to identify and prioritize any business transformation opportunities and evaluate its AWS Cloud readiness.\n\nWhich AWS service or tool should the company use to meet these requirements?',
            'options' => [
                'AWS Cloud Adoption Framework (AWS CAF)',
                'AWS Managed Services (AMS)',
                'AWS Well-Architected Framework',
                'AWS Migration Hub',
            ],
            'correct_answer' => 'AWS Cloud Adoption Framework (AWS CAF)',
            'explanation' => 'AWS Cloud Adoption Framework (AWS CAF) helps organizations plan and accelerate their cloud adoption journey. It provides guidance to identify and prioritize business transformation opportunities, assess cloud readiness, and develop strategies for successful migration and modernization.',
            'sort_order' => 79,
        ]);

        $set->questions()->create([
            'question' => 'Question 80\n\nA company is operating several factories where it builds products. The company needs the ability to process data, store data, and run applications with local system interdependencies that require low latency.\n\nWhich AWS service should the company use to meet these requirements?',
            'options' => [
                'AWS IoT Greengrass',
                'AWS Lambda',
                'AWS Outposts',
                'AWS Snowball Edge',
            ],
            'correct_answer' => 'AWS IoT Greengrass',
            'explanation' => 'AWS IoT Greengrass is designed for edge computing, allowing local processing, storage, and the ability to run applications with low-latency requirements at the edge. It is ideal for environments where there are local system interdependencies, such as in factories, and provides a way to extend AWS Cloud capabilities to local devices.',
            'sort_order' => 80,
        ]);

        $set->questions()->create([
            'question' => 'Question 81\n\nWhich AWS service provides machine learning capability to detect and analyze content in images and videos?',
            'options' => [
                'Amazon Connect',
                'Amazon Lightsail',
                'Amazon Personalize',
                'Amazon Rekognition',
            ],
            'correct_answer' => 'Amazon Rekognition',
            'explanation' => 'Amazon Rekognition is a machine learning service that can analyze images and videos to detect objects, scenes, faces, text, activities, and inappropriate content. It enables developers to add image and video analysis capabilities to applications without requiring machine learning expertise.',
            'sort_order' => 81,
        ]);

        $set->questions()->create([
            'question' => 'Question 82\n\nA company needs to reserve a certain amount of Amazon EC2 compute resources in a specific Availability Zone within an AWS Region.\n\nWhich purchasing option should the company use to meet this requirement?',
            'options' => [
                'EC2 Instance Savings Plans',
                'Compute Savings Plans',
                'Regional Reserved Instances',
                'Zonal Reserved Instances',
            ],
            'correct_answer' => 'Zonal Reserved Instances',
            'explanation' => 'Zonal Reserved Instances allow a company to reserve Amazon EC2 compute resources in a specific Availability Zone within an AWS Region. This provides capacity reservations and offers a discount compared to On-Demand pricing, ensuring that the required compute resources are available in the specified zone.',
            'sort_order' => 82,
        ]);

        $set->questions()->create([
            'question' => 'Question 83\n\nA company needs to organize its resources and track AWS costs on a detailed level. The company needs to categorize costs by business department, environment, and application.\n\nWhich solution will meet these requirements?',
            'options' => [
                'Access the AWS Cost Management console to organize resources, set an AWS budget, and receive notifications of unintentional usage.',
                'Use tags to organize the resources. Activate cost allocation tags to track AWS costs on a detailed level.',
                'Create Amazon CloudWatch dashboards to visually organize and track costs individually.',
                'Access the AWS Billing and Cost Management dashboard to organize and track resource consumption on a detailed level.',
            ],
            'correct_answer' => 'Use tags to organize the resources. Activate cost allocation tags to track AWS costs on a detailed level.',
            'explanation' => 'Use tags to organize the resources. Activate cost allocation tags to track AWS costs on a detailed level.',
            'sort_order' => 83,
        ]);

        $set->questions()->create([
            'question' => 'Question 84\n\nWhich Amazon EC2 instance purchasing option offers the LARGEST discount compared to the price of EC2 On-Demand Instances?',
            'options' => [
                'Savings Plans',
                'Spot Instances',
                'Reserved Instances',
                'Dedicated Hosts',
            ],
            'correct_answer' => 'Spot Instances',
            'explanation' => 'Spot Instances offer the largest discount compared to On-Demand Instances, often up to 90% off. These instances allow you to use spare EC2 capacity at significantly reduced costs, making them highly economical for workloads that are flexible in timing and can tolerate interruptions.',
            'sort_order' => 84,
        ]);

        $set->questions()->create([
            'question' => 'Question 85\n\nA company needs DDoS protection for its AWS resources. The company also needs proactive mitigation assistance from AWS if a DDoS attack occurs.\n\nWhich AWS service will meet these requirements?',
            'options' => [
                'Amazon GuardDuty',
                'AWS Network Firewall',
                'AWS Shield Advanced',
                'AWS WAF',
            ],
            'correct_answer' => 'AWS Shield Advanced',
            'explanation' => 'AWS Shield Advanced provides DDoS protection for AWS resources with advanced features such as proactive mitigation assistance, cost protection for scaling during attacks, and 24/7 access to the AWS DDoS Response Team (DRT) for expert support during attacks.',
            'sort_order' => 85,
        ]);

        $set->questions()->create([
            'question' => 'Question 86\n\nA company needs to collect performance metrics about its Amazon RDS instances and Amazon EC2 instances.\n\nWhich AWS service meets this requirement?',
            'options' => [
                'AWS CloudTrail',
                'Amazon CloudWatch',
                'Amazon Inspector',
                'AWS Config',
            ],
            'correct_answer' => 'Amazon CloudWatch',
            'explanation' => 'Amazon CloudWatch is a monitoring and observability service that collects performance metrics and operational data for AWS resources such as Amazon RDS instances and Amazon EC2 instances. It enables you to monitor metrics like CPU utilization, memory usage, and database connections, and to set alarms for performance thresholds.',
            'sort_order' => 86,
        ]);

        $set->questions()->create([
            'question' => 'Question 87\n\nA company has batch workloads that need to run for short periods of time on Amazon EC2. The workloads can handle interruptions and can start again from where they ended.\n\nWhat is the MOST cost-effective EC2 instance purchasing option to meet these requirements?',
            'options' => [
                'Reserved Instances',
                'Spot Instances',
                'Dedicated Instances',
                'On-Demand Instances',
            ],
            'correct_answer' => 'Spot Instances',
            'explanation' => 'Spot Instances are the most cost-effective option for batch workloads that are fault-tolerant and can handle interruptions. Since the workloads can resume from where they stopped, Spot Instances provide significant cost savings by using unused EC2 capacity at discounted prices.',
            'sort_order' => 87,
        ]);

        $set->questions()->create([
            'question' => 'Question 88\n\nWhich options are benefits of using third-party software from AWS Marketplace? (Choose two.)',
            'options' => [
                'The software\'s data encryption is managed by a third-party vendor.',
                'The software has been evaluated by vendors to ensure that it will run on AWS.',
                'Users do not need to upgrade to newer software versions.',
                'Users do not need to conduct security testing on the software.',
                'Users can launch preconfigured software in only a few steps.',
            ],
            'correct_answer' => '[1,4]',
            'explanation' => 'The software has been evaluated by vendors to ensure that it will run on AWS. AWS Marketplace ensures that third-party software is tested and compatible with the AWS environment, providing users with reliable and optimized solutions. Users can launch preconfigured software in only a few steps. AWS Marketplace provides preconfigured software solutions that are easy to deploy, reducing the time and effort needed to set up complex applications.',
            'sort_order' => 88,
        ]);

        $set->questions()->create([
            'question' => 'Question 89\n\nWhich AWS Cloud Adoption Framework (AWS CAF) perspective includes the incident and problem management capability?',
            'options' => [
                'Business',
                'Operations',
                'Platform',
                'Security',
            ],
            'correct_answer' => 'Operations',
            'explanation' => 'The Operations perspective of the AWS Cloud Adoption Framework (AWS CAF) focuses on the ongoing management and operation of AWS environments. This perspective includes capabilities such as incident management, problem management, and ensuring operational efficiency and resilience. It is crucial for monitoring, maintaining, and responding to issues in the cloud environment.',
            'sort_order' => 89,
        ]);

        $set->questions()->create([
            'question' => 'Question 90\n\nA company wants to migrate its on-premises infrastructure to the AWS Cloud.\n\nWhich advantage of cloud computing will help the company reduce upfront costs?',
            'options' => [
                'Go global in minutes',
                'Increase speed and agility',
                'Benefit from massive economies of scale',
                'Trade fixed expense for variable expense',
            ],
            'correct_answer' => 'Trade fixed expense for variable expense',
            'explanation' => 'Trade fixed expense for variable expense is one of the key advantages of cloud computing. Instead of investing in physical infrastructure with large upfront capital expenses (CapEx), companies pay only for the AWS resources they use (OpEx), helping reduce upfront costs.',
            'sort_order' => 90,
        ]);

        $set->questions()->create([
            'question' => 'Question 91\n\nA company wants to transport 100 TB of data from its data center to AWS without using the internet.\n\nWhich AWS service will meet this requirement?',
            'options' => [
                'AWS Snowcone',
                'AWS Snowball Edge',
                'AWS Data Exchange',
                'AWS DataSync',
            ],
            'correct_answer' => 'AWS Snowball Edge',
            'explanation' => 'AWS Snowball Edge is designed for transferring large amounts of data (such as 100 TB) to AWS without using the internet. It allows for secure and efficient data transfer by using a physical appliance that is shipped to the customer\'s location, where they can load their data onto it before returning it to AWS for upload. This service is ideal for scenarios where internet bandwidth is limited or where transferring data over the internet would be impractical.',
            'sort_order' => 91,
        ]);

        $set->questions()->create([
            'question' => 'Question 92\n\nWhich task is the responsibility of AWS, according to the AWS shared responsibility model?',
            'options' => [
                'Apply guest operating system patches to Amazon EC2 instances.',
                'Provide monitoring of human resources information management (HRIM) systems.',
                'Perform automated backups of Amazon RDS instances.',
                'Optimize the costs of running AWS services.',
            ],
            'correct_answer' => 'Perform automated backups of Amazon RDS instances.',
            'explanation' => 'For Amazon RDS, AWS is responsible for managing the underlying infrastructure and performing automated backups when they are enabled. Under the AWS Shared Responsibility Model, this is part of AWS\'s responsibility for managing the cloud infrastructure and managed services.',
            'sort_order' => 92,
        ]);

        $set->questions()->create([
            'question' => 'Question 93\n\nA company hosts a web application on AWS. The company has improved the availability of its application by provisioning multiple Amazon EC2 instances. The company wants to distribute its traffic across the EC2 instances while providing a single point of contact to the web clients.\n\nWhich AWS service can distribute the traffic to multiple EC2 instances as targets?',
            'options' => [
                'VPC endpoints',
                'Application Load Balancer',
                'NAT gateway',
                'Internet gateway',
            ],
            'correct_answer' => 'Application Load Balancer',
            'explanation' => 'An Application Load Balancer (ALB) distributes incoming HTTP and HTTPS traffic across multiple Amazon EC2 instances, providing a single entry point for clients. It improves application availability, scalability, and fault tolerance by routing requests to healthy EC2 instances.',
            'sort_order' => 93,
        ]);

        $set->questions()->create([
            'question' => 'Question 94\n\nWhich AWS feature or resource is a deployable Amazon EC2 instance template that is prepackaged with software and security requirements?',
            'options' => [
                'Amazon Elastic Block Store (Amazon EBS) volume',
                'AWS CloudFormation template',
                'Amazon Elastic Block Store (Amazon EBS) snapshot',
                'Amazon Machine Image (AMI)',
            ],
            'correct_answer' => 'Amazon Machine Image (AMI)',
            'explanation' => 'An Amazon Machine Image (AMI) is a preconfigured template for launching Amazon EC2 instances. It includes the operating system, application software, and security configurations required to create and deploy EC2 instances quickly and consistently.',
            'sort_order' => 94,
        ]);

        $set->questions()->create([
            'question' => 'Question 95\n\nA company needs to identify who accessed an AWS service and what action was performed for a given time period.\n\nWhich AWS service should the company use to meet this requirement?',
            'options' => [
                'Amazon CloudWatch',
                'AWS CloudTrail',
                'AWS Security Hub',
                'Amazon Inspector',
            ],
            'correct_answer' => 'AWS CloudTrail',
            'explanation' => 'AWS CloudTrail records AWS API activity and account events, allowing companies to identify who accessed AWS services, what actions were performed, when the actions occurred, and from where the requests originated. It is the primary service for auditing, governance, and compliance in AWS.',
            'sort_order' => 95,
        ]);

        $set->questions()->create([
            'question' => 'Question 96\n\nWhat does "security of the cloud" refer to in the AWS shared responsibility model?',
            'options' => [
                'Availability of AWS services such as Amazon EC2',
                'Security of the cloud infrastructure that runs all the AWS services',
                'Implementation of password policies for IAM users',
                'Security of customer environments by using AWS Network Firewall partners',
            ],
            'correct_answer' => 'Security of the cloud infrastructure that runs all the AWS services',
            'explanation' => 'In the AWS Shared Responsibility Model, security of the cloud refers to AWS\'s responsibility for protecting the infrastructure that runs all AWS services. This includes the physical facilities, networking, hardware, software, and virtualization layer that support the AWS Cloud.',
            'sort_order' => 96,
        ]);

        $set->questions()->create([
            'question' => 'Question 97\n\nA company runs an on-premises contact center for customers. The company needs to migrate to a cloud-based solution that can deliver artificial intelligence features to improve user experience.\n\nWhich AWS service will meet these requirements?',
            'options' => [
                'AWS Wavelength',
                'AWS IAM Identity Center (AWS Single Sign-On)',
                'AWS Direct Connect',
                'Amazon Connect',
            ],
            'correct_answer' => 'Amazon Connect',
            'explanation' => 'Amazon Connect is a cloud-based contact center service that enables companies to migrate from on-premises contact centers to the AWS Cloud. It integrates with AWS AI services, such as Amazon Lex and Amazon Polly, to provide intelligent features like chatbots, speech recognition, and natural language interactions that improve the customer experience.',
            'sort_order' => 97,
        ]);

        $set->questions()->create([
            'question' => 'Question 98\n\nA company needs a hybrid cloud storage service to connect its on-premises environment to scalable AWS Cloud storage.\n\nWhich AWS service will meet these requirements?',
            'options' => [
                'Amazon S3',
                'Amazon FSx',
                'AWS Storage Gateway',
                'AWS Fargate',
            ],
            'correct_answer' => 'AWS Storage Gateway',
            'explanation' => 'AWS Storage Gateway is a hybrid cloud storage service that enables on-premises applications to seamlessly use scalable cloud storage. It connects on-premises environments to AWS Cloud storage services like Amazon S3, Amazon FSx, or Amazon EBS, allowing for use cases like backup, archiving, and disaster recovery while integrating with existing on-premises workflows.',
            'sort_order' => 98,
        ]);

        $set->questions()->create([
            'question' => 'Question 99\n\nWhich AWS service is designed for users running workloads that include a NoSQL database?',
            'options' => [
                'Amazon RDS',
                'Amazon S3',
                'Amazon Redshift',
                'Amazon DynamoDB',
            ],
            'correct_answer' => 'Amazon DynamoDB',
            'explanation' => 'Amazon DynamoDB is a fully managed NoSQL database service designed for applications that require low-latency performance, high scalability, and flexible data models. It supports key-value and document data structures, making it ideal for NoSQL workloads.',
            'sort_order' => 99,
        ]);

        $set->questions()->create([
            'question' => 'Question 100\n\nA company wants to migrate all of its on-premises infrastructure to the AWS Cloud. Before migration, the company wants an estimate of costs for running its as-is infrastructure.\n\nWhich AWS service or principle should the company use to meet this requirement?',
            'options' => [
                'AWS Pricing Calculator',
                'AWS Well-Architected Framework',
                'AWS shared responsibility model',
                'AWS Cloud Adoption Framework (AWS CAF)',
            ],
            'correct_answer' => 'AWS Pricing Calculator',
            'explanation' => 'AWS Pricing Calculator helps estimate the cost of running workloads on AWS before migration. It allows companies to model their existing on-premises infrastructure, configure AWS services, and generate a detailed cost estimate for their planned AWS environment.',
            'sort_order' => 100,
        ]);

        $set->questions()->create([
            'question' => 'Question 101\n\nA company needs to analyze more than 200,000 financial records that are generated each day. The company must use containerized applications to perform the analysis and automate the process.\n\nWhich AWS service will meet these requirements?',
            'options' => [
                'Amazon Athena',
                'AWS Database Migration Service (AWS DMS)',
                'AWS Batch',
                'AWS Systems Manager',
            ],
            'correct_answer' => 'AWS Batch',
            'explanation' => 'Answer: C. AWS Batch',
            'sort_order' => 101,
        ]);

        $set->questions()->create([
            'question' => 'Question 102\n\nA company needs to store infrequently used data for data archives and long-term backups.\n\nWhich AWS service or storage class will meet these requirements MOST cost-effectively?',
            'options' => [
                'Amazon FSx for Lustre',
                'Amazon Elastic Block Store (Amazon EBS)',
                'Amazon Elastic File System (Amazon EFS)',
                'Amazon S3 Glacier Flexible Retrieval',
            ],
            'correct_answer' => 'Amazon S3 Glacier Flexible Retrieval',
            'explanation' => 'Answer: D. Amazon S3 Glacier Flexible Retrieval',
            'sort_order' => 102,
        ]);

        $set->questions()->create([
            'question' => 'Question 103\n\nA company is building a web application that requires an in-memory data store for caching and session management. The data store must provide high availability and durability.\n\nWhich AWS service or resource will meet these requirements?',
            'options' => [
                'Amazon Aurora',
                'Amazon ElastiCache (Memcached)',
                'Amazon Elastic Block Store (Amazon EBS) volumes',
                'Amazon MemoryDB',
            ],
            'correct_answer' => 'Amazon MemoryDB',
            'explanation' => 'Answer: D. Amazon MemoryDB',
            'sort_order' => 103,
        ]);

        $set->questions()->create([
            'question' => 'Question 104\n\nWhat is the primary use case for Amazon GuardDuty?',
            'options' => [
                'Prevention of DDoS attacks',
                'Protection against SQL injection attacks',
                'Automatic monitoring for threats to AWS workloads',
                'Automatic provisioning of AWS resources',
            ],
            'correct_answer' => 'Automatic monitoring for threats to AWS workloads',
            'explanation' => 'Answer: C. Automatic monitoring for threats to AWS workloads',
            'sort_order' => 104,
        ]);

        $set->questions()->create([
            'question' => 'Question 105\n\nWhich AWS service gives a company the ability to use a private, dedicated connection between a VPC and an on-premises data center?',
            'options' => [
                'AWS Direct Connect',
                'Amazon API Gateway',
                'AWS Systems Manager',
                'AWS CloudFormation',
            ],
            'correct_answer' => 'AWS Direct Connect',
            'explanation' => 'AWS Direct Connect provides a dedicated, private network connection between an on-premises data center and AWS. It allows for consistent, low-latency, and high-throughput network performance, bypassing the public internet for more secure and reliable communication between your on-premises infrastructure and AWS VPCs.',
            'sort_order' => 105,
        ]);

        $set->questions()->create([
            'question' => 'Question 106\n\nWhich capabilities are in the governance perspective of the AWS Cloud Adoption Framework (AWS CAF)? (Choose two.)',
            'options' => [
                'Benefits management',
                'Data monetization',
                'Data curation',
                'Change acceleration',
                'Patch management',
            ],
            'correct_answer' => '[0,3]',
            'explanation' => 'The Governance Perspective in the AWS Cloud Adoption Framework (AWS CAF) focuses on aligning IT strategy with business goals, managing change, and measuring progress to achieve desired outcomes during cloud adoption. Benefits management ensures that the organization is tracking and realizing the expected business benefits of cloud adoption. Change acceleration involves preparing and enabling the organization to manage changes effectively as part of the cloud transformation process.',
            'sort_order' => 106,
        ]);

        $set->questions()->create([
            'question' => 'Question 107\n\nA company must provide a list of its IAM users to an external auditor. The list must include the status of the users\' credentials and access keys.\n\nWhat is the MOST operationally efficient way to provide this information?',
            'options' => [
                'Create an IAM user account for the auditor. Grant the auditor administrator permissions.',
                'Download the IAM credential report. Provide the report to the auditor.',
                'Download the AWS Trusted Advisor report. Provide the report to the auditor.',
                'Take a screenshot of each user\'s page in the AWS Management Console. Provide the screenshots to the auditor.',
            ],
            'correct_answer' => 'Download the IAM credential report. Provide the report to the auditor.',
            'explanation' => 'The IAM credential report is a built-in feature in AWS that provides a detailed overview of all IAM users in an account, including the status of their credentials and access keys. It is the most efficient and secure way to generate and share the required information for an audit.',
            'sort_order' => 107,
        ]);

        $set->questions()->create([
            'question' => 'Question 108\n\nA company needs to consolidate the billing for multiple AWS accounts. The company needs to use one account to pay on behalf of all the other accounts.\n\nWhich AWS service or tool should the company use to meet this requirement?',
            'options' => [
                'AWS Trusted Advisor',
                'AWS Organizations',
                'AWS Budgets',
                'AWS Service Catalog',
            ],
            'correct_answer' => 'AWS Organizations',
            'explanation' => 'AWS Organizations enables centralized management of multiple AWS accounts. It supports consolidated billing, allowing one management account to pay the charges for all member accounts. This simplifies billing, enables cost tracking across accounts, and allows the organization to share benefits such as volume pricing and Reserved Instance discounts.',
            'sort_order' => 108,
        ]);

        $set->questions()->create([
            'question' => 'Question 109\n\nWhich cloud concept is demonstrated by using AWS Cost Explorer?',
            'options' => [
                'Rightsizing',
                'Reliability',
                'Resilience',
                'Modernization',
            ],
            'correct_answer' => 'Rightsizing',
            'explanation' => 'AWS Cost Explorer helps users analyze AWS costs and usage over time. It provides recommendations to identify underutilized or overprovisioned resources, enabling customers to choose the appropriate resource size for their workloads. This cloud cost optimization practice is known as rightsizing, which helps reduce unnecessary expenses while maintaining application performance.',
            'sort_order' => 109,
        ]);

        $set->questions()->create([
            'question' => 'Question 110\n\nWhich pillar of the AWS Well-Architected Framework includes a design principle about measuring the overall efficiency of workloads in terms of business value?',
            'options' => [
                'Operational excellence',
                'Security',
                'Reliability',
                'Cost optimization',
            ],
            'correct_answer' => 'Cost optimization',
            'explanation' => 'Cost optimization includes the design principle of measuring the overall efficiency of workloads in terms of business value. It emphasizes ensuring that the architecture delivers value efficiently by balancing cost and performance to meet business objectives.',
            'sort_order' => 110,
        ]);

        $set->questions()->create([
            'question' => "Question 111\n\nA company wants to securely store Amazon RDS database credentials and automatically rotate user passwords periodically.\n\nWhich AWS service or capability will meet these requirements?",
            'options' => [
                'Amazon S3',
                'AWS Systems Manager Parameter Store',
                'AWS Secrets Manager',
                'AWS CloudTrail',
            ],
            'correct_answer' => 'AWS Secrets Manager',
            'explanation' => 'AWS Secrets Manager is designed to securely store database credentials, secrets, and API keys. It also supports automatic rotation of Amazon RDS credentials on a schedule, which makes it the right choice for this requirement.',
            'sort_order' => 111,
        ]);

        $set->questions()->create([
            'question' => "Question 112\n\nA company runs critical workloads on AWS. The company needs a response from AWS technical support within 15 minutes if a critical system goes down.\n\nWhich AWS Support plan offers this response time?",
            'options' => [
                'AWS Basic Support',
                'AWS Business Support',
                'AWS Enterprise Support',
                'AWS Developer Support',
            ],
            'correct_answer' => 'AWS Enterprise Support',
            'explanation' => 'AWS Enterprise Support provides a 15-minute response time for business-critical system down issues (Severity 1). It is intended for mission-critical workloads and includes proactive guidance and additional support features such as a Technical Account Manager.',
            'sort_order' => 112,
        ]);

        $set->questions()->create([
            'question' => "Question 113\n\nWhich AWS offering provides functionality to set up cloud-based customer service contact centers?",
            'options' => [
                'Amazon Pinpoint',
                'Amazon Connect',
                'Amazon Athena',
                'AWS Enterprise Support',
            ],
            'correct_answer' => 'Amazon Connect',
            'explanation' => 'Amazon Connect is a cloud-based contact center service that helps businesses set up and operate customer service contact centers. It includes capabilities such as call routing, analytics, and integration with other AWS services.',
            'sort_order' => 113,
        ]);

        $set->questions()->create([
            'question' => "Question 114\n\nWhich of the following can be components of a VPC in the AWS Cloud? (Choose two.)",
            'options' => [
                'Amazon API Gateway',
                'Amazon S3 buckets and objects',
                'AWS Storage Gateway',
                'Internet gateway',
                'Subnet',
            ],
            'correct_answer' => '[3,4]',
            'explanation' => 'An internet gateway and subnets are core components of a VPC. An internet gateway enables communication between the VPC and the internet, and subnets divide the VPC network into smaller segments within Availability Zones.',
            'sort_order' => 114,
        ]);

        $set->questions()->create([
            'question' => "Question 115\n\nFor which task does AWS Trusted Advisor provide guidance?",
            'options' => [
                'Auditing of AWS account activity',
                'Troubleshooting of connectivity issues',
                'Elimination of unused and idle resources',
                'Implementation of migration assessments',
            ],
            'correct_answer' => 'Elimination of unused and idle resources',
            'explanation' => 'AWS Trusted Advisor provides recommendations to optimize AWS environments, including identifying unused and idle resources to help reduce costs. It also offers guidance in areas such as security, performance, fault tolerance, and service limits.',
            'sort_order' => 115,
        ]);

        $set->questions()->create([
            'question' => "Question 116\n\nA company hosts its website on Amazon EC2 instances. The company needs to ensure that the website reaches a global audience and provides minimum latency to users.\n\nWhich AWS service should the company use to meet these requirements?",
            'options' => [
                'Amazon Route 53',
                'Amazon CloudFront',
                'Elastic Load Balancing',
                'AWS Lambda',
            ],
            'correct_answer' => 'Amazon CloudFront',
            'explanation' => 'Amazon CloudFront is a global content delivery network (CDN) that caches content at edge locations worldwide to reduce latency and improve performance for users across different geographic regions.',
            'sort_order' => 116,
        ]);

        $set->questions()->create([
            'question' => "Question 117\n\nA company needs to provide customer service by using voice calls and web chat features.\n\nWhich AWS service should the company use to meet these requirements?",
            'options' => [
                'Amazon Aurora',
                'Amazon Connect',
                'Amazon WorkSpaces',
                'AWS Organizations',
            ],
            'correct_answer' => 'Amazon Connect',
            'explanation' => 'Amazon Connect is a cloud-based contact center service that supports both voice calls and web chat, making it suitable for customer service use cases across multiple communication channels.',
            'sort_order' => 117,
        ]);

        $set->questions()->create([
            'question' => "Question 118\n\nA company has a web application that has users all over the world. The company is moving the application to AWS to improve speed for the users. The company needs an AWS service that delivers the application content through data centers around the world.\n\nWhich AWS service or feature will meet these requirements?",
            'options' => [
                'Amazon Connect',
                'AWS Config',
                'AWS AppSync',
                'Edge locations',
            ],
            'correct_answer' => 'Edge locations',
            'explanation' => 'Edge locations are globally distributed data centers used by Amazon CloudFront to cache and deliver content closer to users, which reduces latency and improves performance for web applications around the world.',
            'sort_order' => 118,
        ]);

        $set->questions()->create([
            'question' => "Question 119\n\nWhich AWS Cloud Adoption Framework (AWS CAF) perspective focuses on organizing an inventory of data products in a data catalog?",
            'options' => [
                'Operations',
                'Governance',
                'Business',
                'Platform',
            ],
            'correct_answer' => 'Governance',
            'explanation' => 'The Governance perspective includes data curation capabilities. It focuses on organizing and maintaining an inventory of data products in a data catalog.',
            'sort_order' => 119,
        ]);

        $set->questions()->create([
            'question' => "Question 120\n\nWhich advantage of cloud computing allows users to scale resources up and down based on the amount of load that an application supports?",
            'options' => [
                'Go global in minutes',
                'Stop guessing capacity',
                'Benefit from massive economies of scale',
                'Trade fixed expense for variable expense',
            ],
            'correct_answer' => 'Stop guessing capacity',
            'explanation' => 'Cloud computing allows users to increase or decrease resources according to actual demand, so they do not need to predict the required capacity in advance. This advantage is described as stopping the need to guess capacity.',
            'sort_order' => 120,
        ]);

        $set->questions()->create([
            'question' => "Question 121\n\nA company needs to set up alerts that occur when the actual or forecasted costs of AWS services exceed a defined threshold.\n\nWhich AWS service or tool should the company use to meet this requirement?",
            'options' => [
                'AWS Cost Explorer',
                'AWS Budgets',
                'AWS Cost and Usage Report',
                'AWS CloudTrail',
            ],
            'correct_answer' => 'AWS Budgets',
            'explanation' => 'AWS Budgets allows users to create custom cost and usage budgets and receive alerts when actual or forecasted spending exceeds a defined threshold. Notifications can be sent by email or Amazon SNS.',
            'sort_order' => 121,
        ]);

        $set->questions()->create([
            'question' => "Question 122\n\nA company needs to create a portfolio that provides central management of approved IT services.\n\nWhich AWS service offers this functionality?",
            'options' => [
                'AWS Service Catalog',
                'AWS Control Tower',
                'AWS Cloud Map',
                'AWS Clean Rooms',
            ],
            'correct_answer' => 'AWS Service Catalog',
            'explanation' => 'AWS Service Catalog enables organizations to create, manage, and govern a catalog of approved IT services. It provides centralized management to support compliance, standardization, and controlled access to approved services.',
            'sort_order' => 122,
        ]);

        $set->questions()->create([
            'question' => "Question 123\n\nWhich of the following are customer responsibilities under the AWS shared responsibility model? (Choose two.)",
            'options' => [
                'Physical security of AWS facilities',
                'Configuration of security groups',
                'Encryption of customer data on AWS',
                'Management of AWS Lambda infrastructure',
                'Management of network throughput of each AWS Region',
            ],
            'correct_answer' => '[1,2]',
            'explanation' => 'Customers are responsible for configuring security groups and for deciding how to encrypt and protect their data in AWS. AWS provides the infrastructure and encryption-capable services, but customers configure security controls and data protection settings.',
            'sort_order' => 123,
        ]);

        $set->questions()->create([
            'question' => "Question 124\n\nA company needs to receive rightsizing recommendations that help identify cost-saving opportunities for Amazon EC2 instances.\n\nWhich AWS service or tool will provide these recommendations?",
            'options' => [
                'AWS Config',
                'AWS Cost Explorer',
                'Amazon Inspector',
                'Amazon Lightsail',
            ],
            'correct_answer' => 'AWS Cost Explorer',
            'explanation' => 'AWS Cost Explorer provides rightsizing recommendations for Amazon EC2 instances by analyzing usage patterns. It helps identify underutilized instances and suggests changes that can reduce cost and improve resource efficiency.',
            'sort_order' => 124,
        ]);

        $set->questions()->create([
            'question' => "Question 125\n\nA company wants to improve employee productivity by providing a way for employees to search for questions and retrieve specific answers. The company wants to use a single intelligent search interface.\n\nWhich AWS service will meet these requirements?",
            'options' => [
                'Amazon Connect',
                'Amazon Kendra',
                'Amazon Lex',
                'Amazon Comprehend',
            ],
            'correct_answer' => 'Amazon Kendra',
            'explanation' => 'Amazon Kendra is an intelligent enterprise search service that uses machine learning to help users search across multiple data sources through a single interface and retrieve relevant, specific answers quickly.',
            'sort_order' => 125,
        ]);

        $set->questions()->create([
            'question' => "Question 126\n\nA company wants to organize its users so that the company can grant permissions to the users as a group.\n\nWhich AWS service or tool can the company use to meet this requirement?",
            'options' => [
                'Security groups',
                'AWS Identity and Access Management (IAM)',
                'Resource groups',
                'AWS Security Hub',
            ],
            'correct_answer' => 'AWS Identity and Access Management (IAM)',
            'explanation' => 'AWS IAM allows a company to create IAM groups and add users to those groups. Permissions can then be assigned to the group by using IAM policies, so all users in the group receive the same permissions.',
            'sort_order' => 126,
        ]);

        $set->questions()->create([
            'question' => "Question 127\n\nA company needs centralized storage to manage the configuration data and passwords for its applications.\n\nWhich AWS service or capability will meet these requirements?",
            'options' => [
                'AWS CodeArtifact',
                'AWS Config',
                'AWS Security Hub',
                'AWS Systems Manager Parameter Store',
            ],
            'correct_answer' => 'AWS Systems Manager Parameter Store',
            'explanation' => 'AWS Systems Manager Parameter Store provides centralized storage for configuration data and secrets such as passwords and API keys. It supports encryption, fine-grained access control, and secure retrieval for applications.',
            'sort_order' => 127,
        ]);

        $set->questions()->create([
            'question' => "Question 128\n\nA company is releasing a business-critical application. Before the release, the company needs strategic planning assistance from AWS. During the release, the company needs AWS infrastructure event management and real-time support.\n\nWhat should the company do to meet these requirements?",
            'options' => [
                'Access AWS Trusted Advisor',
                'Contact the AWS Partner Network (APN)',
                'Sign up for AWS Enterprise Support',
                'Contact AWS Professional Services',
            ],
            'correct_answer' => 'Sign up for AWS Enterprise Support',
            'explanation' => 'AWS Enterprise Support provides strategic planning assistance through a Technical Account Manager and includes AWS Infrastructure Event Management plus real-time support for important business-critical events and releases.',
            'sort_order' => 128,
        ]);

        $set->questions()->create([
            'question' => "Question 129\n\nA company is deploying a mobile app on AWS. Thousands of users will access the app.\n\nWhich AWS service should the company use to create a directory to manage sign-in for the users?",
            'options' => [
                'AWS Directory Service',
                'AWS IAM Identity Center',
                'Amazon Cognito',
                'AWS Identity and Access Management (IAM)',
            ],
            'correct_answer' => 'Amazon Cognito',
            'explanation' => 'Amazon Cognito is designed to manage user authentication and sign-in for web and mobile applications. It provides user directories, federation options, and features such as MFA, making it suitable for large numbers of application users.',
            'sort_order' => 129,
        ]);

        $set->questions()->create([
            'question' => "Question 130\n\nA company wants to discover, prepare, move, and integrate data from multiple sources for data analytics and machine learning.\n\nWhich AWS serverless data integration service should the company use to meet these requirements?",
            'options' => [
                'AWS Glue',
                'AWS Data Exchange',
                'Amazon Athena',
                'Amazon EMR',
            ],
            'correct_answer' => 'AWS Glue',
            'explanation' => 'AWS Glue is a serverless data integration service that helps discover, prepare, move, and integrate data from multiple sources. It is commonly used to prepare data for analytics, machine learning, and application development.',
            'sort_order' => 130,
        ]);

        $set->questions()->create([
            'question' => "Question 131\n\nA security engineer wants a single-tenant AWS solution to create, control, and manage their own cryptographic keys to meet regulatory compliance requirements for data security.\n\nWhich AWS service should the engineer use?",
            'options' => [
                'AWS Key Management Service (AWS KMS)',
                'AWS Certificate Manager (ACM)',
                'AWS CloudHSM',
                'AWS Systems Manager',
            ],
            'correct_answer' => 'AWS CloudHSM',
            'explanation' => 'AWS CloudHSM provides single-tenant hardware security modules that let customers generate, store, and manage their own cryptographic keys in the AWS Cloud. It is designed for workloads with strict regulatory and compliance requirements.',
            'sort_order' => 131,
        ]);

        $set->questions()->create([
            'question' => "Question 132\n\nA company needs to identify unused access that has been granted to users in its AWS accounts.\n\nWhich AWS service or feature will provide this information?",
            'options' => [
                'AWS CloudTrail',
                'AWS IAM Access Analyzer',
                'AWS IAM Identity Center',
                'AWS Trusted Advisor',
            ],
            'correct_answer' => 'AWS IAM Access Analyzer',
            'explanation' => 'AWS IAM Access Analyzer helps identify unused permissions and access granted to users, roles, and resources. It provides insights that help teams remove unnecessary access and apply least-privilege practices.',
            'sort_order' => 132,
        ]);

        $set->questions()->create([
            'question' => "Question 133\n\nA company needs a secure, encrypted connection between its data center workload and the AWS Cloud. The connection needs to use the public internet.\n\nWhich AWS service will meet these requirements?",
            'options' => [
                'AWS Direct Connect',
                'Amazon Connect',
                'AWS Site-to-Site VPN',
                'AWS Client VPN',
            ],
            'correct_answer' => 'AWS Site-to-Site VPN',
            'explanation' => 'AWS Site-to-Site VPN establishes a secure, encrypted connection between an on-premises data center and an AWS VPC over the public internet by using IPsec tunnels to protect data in transit.',
            'sort_order' => 133,
        ]);

        $set->questions()->create([
            'question' => "Question 134\n\nA company that operates on-premises servers decides to start a new line of business. The company determines that additional servers are required for the new workloads.\n\nWhich advantage of cloud computing can help the company to provision additional infrastructure as quickly as possible?",
            'options' => [
                'Benefit from massive economies of scale',
                'Increase speed and agility',
                'Trade fixed expense for variable expense',
                'Go global in minutes',
            ],
            'correct_answer' => 'Increase speed and agility',
            'explanation' => 'Cloud computing allows a company to provision additional infrastructure within minutes instead of waiting to purchase, deliver, and install physical servers. This advantage increases speed and agility and helps the company respond quickly to new business requirements.',
            'sort_order' => 134,
        ]);

        $set->questions()->create([
            'question' => "Question 135\n\nA company needs to identify the last time that a specific user accessed the AWS Management Console.\n\nWhich AWS service will provide this information?",
            'options' => [
                'Amazon Cognito',
                'AWS CloudTrail',
                'Amazon Inspector',
                'Amazon GuardDuty',
            ],
            'correct_answer' => 'AWS CloudTrail',
            'explanation' => 'AWS CloudTrail records API calls and user activities in AWS, including actions taken through the AWS Management Console. Reviewing CloudTrail events allows a company to identify which user accessed the console and when the access occurred.',
            'sort_order' => 135,
        ]);

        $set->questions()->create([
            'question' => "Question 136\n\nWhich AWS network services or features allow CIDR block notation when providing an IP address range? (Choose two.)",
            'options' => [
                'Security groups',
                'Amazon Machine Image (AMI)',
                'Network access control list (network ACL)',
                'AWS Budgets',
                'Amazon Elastic Block Store (Amazon EBS)',
            ],
            'correct_answer' => '[0,2]',
            'explanation' => 'Security groups and network ACLs allow IP address ranges to be specified by using CIDR block notation. Security groups apply at the resource level, while network ACLs apply at the subnet level.',
            'sort_order' => 136,
        ]);

        $set->questions()->create([
            'question' => "Question 137\n\nA company wants to use machine learning capabilities to analyze log data from its Amazon EC2 instances and efficiently conduct security investigations.\n\nWhich AWS service will meet these requirements?",
            'options' => [
                'Amazon Inspector',
                'Amazon QuickSight',
                'Amazon Detective',
                'Amazon GuardDuty',
            ],
            'correct_answer' => 'Amazon Detective',
            'explanation' => 'Amazon Detective uses machine learning, statistical analysis, and graph theory to analyze log data automatically. It helps security teams investigate suspicious activities, identify root causes, and conduct security investigations efficiently.',
            'sort_order' => 137,
        ]);

        $set->questions()->create([
            'question' => "Question 138\n\nWhich AWS service is a browser-based, pre-authenticated command line interface that can be launched directly from the AWS Management Console?",
            'options' => [
                'AWS CloudShell',
                'AWS Fargate',
                'AWS Lambda',
                'AWS Config',
            ],
            'correct_answer' => 'AWS CloudShell',
            'explanation' => 'AWS CloudShell is a browser-based, pre-authenticated command line interface that launches directly from the AWS Management Console. It includes preconfigured AWS credentials and common tools so users can manage AWS resources without setting up a local CLI.',
            'sort_order' => 138,
        ]);

        $set->questions()->create([
            'question' => "Question 139\n\nA developer needs to maintain a development environment infrastructure and a production environment infrastructure in a repeatable fashion.\n\nWhich AWS service should the developer use to meet these requirements?",
            'options' => [
                'AWS Ground Station',
                'AWS Shield',
                'AWS IoT Device Defender',
                'AWS CloudFormation',
            ],
            'correct_answer' => 'AWS CloudFormation',
            'explanation' => 'AWS CloudFormation lets developers define infrastructure as code by using templates. The same template can be reused to create consistent development and production environments with less manual effort and fewer configuration errors.',
            'sort_order' => 139,
        ]);

        $set->questions()->create([
            'question' => "Question 140\n\nWhich task is the customer's responsibility, according to the AWS shared responsibility model?",
            'options' => [
                'Patch a guest operating system that is deployed on an Amazon EC2 instance.',
                'Control physical access to an AWS data center.',
                'Control access to AWS underlying hardware.',
                'Patch a host operating system that is deployed on Amazon S3.',
            ],
            'correct_answer' => 'Patch a guest operating system that is deployed on an Amazon EC2 instance.',
            'explanation' => 'Under the AWS shared responsibility model, customers are responsible for security in the cloud. For Amazon EC2, this includes maintaining and patching the guest operating system. AWS is responsible for physical data centers, underlying hardware, and the managed host infrastructure.',
            'sort_order' => 140,
        ]);

        $set->questions()->create([
            'question' => "Question 141\n\nA company is moving its development and test environments to AWS to increase agility and reduce cost. Because these are not production workloads and the servers are not fully utilized, occasional unavailability is acceptable.\n\nWhat is the MOST cost-effective Amazon EC2 pricing model that will meet these requirements?",
            'options' => [
                'Reserved Instances',
                'On-Demand Instances',
                'Spot Instances',
                'Dedicated Hosts',
            ],
            'correct_answer' => 'Spot Instances',
            'explanation' => 'Spot Instances use unused Amazon EC2 capacity and are offered at a significant discount compared with On-Demand Instances. Because AWS can interrupt them, they are a strong fit for development and test workloads that can tolerate occasional unavailability.',
            'sort_order' => 141,
        ]);

        $set->questions()->create([
            'question' => "Question 142\n\nWhich AWS service gives users the ability to simplify costs and take advantage of quantity discounts with a single bill?",
            'options' => [
                'Service Quotas',
                'AWS Service Catalog',
                'AWS Control Tower',
                'AWS Organizations',
            ],
            'correct_answer' => 'AWS Organizations',
            'explanation' => 'AWS Organizations supports consolidated billing across multiple AWS accounts. This gives customers a single bill and can combine usage to help qualify for volume pricing and quantity discounts.',
            'sort_order' => 142,
        ]);

        $set->questions()->create([
            'question' => "Question 143\n\nWhich AWS service or feature requires an internet service provider (ISP) and a colocation facility to be implemented?",
            'options' => [
                'AWS VPN',
                'Amazon Connect',
                'AWS Direct Connect',
                'Internet gateway',
            ],
            'correct_answer' => 'AWS Direct Connect',
            'explanation' => 'AWS Direct Connect provides a dedicated private network connection between an on-premises environment and AWS. It typically involves an ISP or Direct Connect Partner and physical connectivity through a colocation facility.',
            'sort_order' => 143,
        ]);

        $set->questions()->create([
            'question' => "Question 144\n\nWhat is the scope of a VPC within the AWS network?",
            'options' => [
                'A VPC can span all Availability Zones globally.',
                'A VPC must span at least two subnets in each AWS Region.',
                'A VPC must span at least two edge locations in each AWS Region.',
                'A VPC can span all Availability Zones within an AWS Region.',
            ],
            'correct_answer' => 'A VPC can span all Availability Zones within an AWS Region.',
            'explanation' => 'A VPC is scoped to a single AWS Region and can span all Availability Zones within that Region. Subnets inside the VPC are each tied to a single Availability Zone, which supports high availability and fault isolation.',
            'sort_order' => 144,
        ]);

        $set->questions()->create([
            'question' => "Question 145\n\nWhich of the following are design principles for reliability in the AWS Cloud? (Choose two.)",
            'options' => [
                'Build architectures with tightly coupled resources.',
                'Use AWS Trusted Advisor to meet security best practices.',
                'Use automation to recover immediately from failure.',
                'Rightsize Amazon EC2 instances to ensure optimal performance.',
                'Simulate failures to test recovery processes.',
            ],
            'correct_answer' => '[2,4]',
            'explanation' => 'Reliability design principles include automatically recovering from failure and testing recovery procedures by simulating failures. These practices help systems restore service quickly and confirm that resilience mechanisms actually work.',
            'sort_order' => 145,
        ]);

        $set->questions()->create([
            'question' => "Question 146\n\nA company wants to run its application by using containers on AWS.\n\nWhich AWS services or tools will provide container orchestration? (Choose two.)",
            'options' => [
                'Amazon Elastic Container Service (Amazon ECS)',
                'AWS Wavelength',
                'Amazon Inspector',
                'Amazon Elastic Kubernetes Service (Amazon EKS)',
                'AWS Copilot',
            ],
            'correct_answer' => '[0,3]',
            'explanation' => 'Amazon ECS and Amazon EKS are AWS container orchestration services. ECS is a fully managed container orchestrator, and EKS is a fully managed Kubernetes service for deploying, managing, and scaling containers on AWS.',
            'sort_order' => 146,
        ]);

        $set->questions()->create([
            'question' => "Question 147\n\nWhich AWS service gives users on-demand, self-service access to AWS compliance control reports?",
            'options' => [
                'AWS Config',
                'Amazon GuardDuty',
                'AWS Trusted Advisor',
                'AWS Artifact',
            ],
            'correct_answer' => 'AWS Artifact',
            'explanation' => 'AWS Artifact is a self-service portal that provides on-demand access to AWS security and compliance reports and certifications, such as SOC reports and ISO certifications, to support audit and compliance needs.',
            'sort_order' => 147,
        ]);

        $set->questions()->create([
            'question' => "Question 148\n\nA company needs a managed NFS file system that the company can use with its AWS compute resources.\n\nWhich AWS service or feature will meet these requirements?",
            'options' => [
                'Amazon Elastic Block Store (Amazon EBS)',
                'AWS Storage Gateway Tape Gateway',
                'Amazon S3 Glacier Flexible Retrieval',
                'Amazon Elastic File System (Amazon EFS)',
            ],
            'correct_answer' => 'Amazon Elastic File System (Amazon EFS)',
            'explanation' => 'Amazon EFS is a fully managed and scalable file system that supports the NFS protocol. It can be mounted and shared across multiple AWS compute resources, such as Amazon EC2 instances, at the same time.',
            'sort_order' => 148,
        ]);

        $set->questions()->create([
            'question' => "Question 149\n\nWhich AWS service provides encryption of data at rest for Amazon Elastic Block Store (Amazon EBS)?",
            'options' => [
                'Amazon Cognito',
                'AWS Identity and Access Management (IAM)',
                'AWS Key Management Service (AWS KMS)',
                'AWS Trusted Advisor',
            ],
            'correct_answer' => 'AWS Key Management Service (AWS KMS)',
            'explanation' => 'AWS KMS manages the encryption keys that are used for Amazon EBS encryption. When EBS encryption is enabled, the volume data, snapshots, and data moving between the volume and the attached instance are encrypted automatically.',
            'sort_order' => 149,
        ]);

        $set->questions()->create([
            'question' => "Question 150\n\nA cloud practitioner wants a repeatable way to deploy identical AWS resources by using infrastructure templates.\n\nWhich AWS service will meet these requirements?",
            'options' => [
                'AWS CloudFormation',
                'AWS Directory Service',
                'Amazon Lightsail',
                'AWS CodeDeploy',
            ],
            'correct_answer' => 'AWS CloudFormation',
            'explanation' => 'AWS CloudFormation allows users to define and provision AWS infrastructure by using declarative templates in YAML or JSON format. It can repeatedly deploy identical resources, which supports infrastructure as code and consistency across environments.',
            'sort_order' => 150,
        ]);

        $set->questions()->create([
            'question' => "Question 151\n\nWhich programming languages does AWS Cloud Development Kit (AWS CDK) currently support? (Choose two.)",
            'options' => [
                'Python',
                'Swift',
                'TypeScript',
                'Ruby',
                'PHP',
            ],
            'correct_answer' => '[0,2]',
            'explanation' => 'AWS CDK supports defining cloud infrastructure by using familiar programming languages. In this question set, Python and TypeScript are the correct supported choices among the listed options.',
            'sort_order' => 151,
        ]);

        $set->questions()->create([
            'question' => "Question 152\n\nWhich AWS service requires the customer to be fully responsible for applying operating system patches?",
            'options' => [
                'Amazon DynamoDB',
                'AWS Lambda',
                'AWS Fargate',
                'Amazon EC2',
            ],
            'correct_answer' => 'Amazon EC2',
            'explanation' => 'With Amazon EC2, the customer is responsible for managing the guest operating system, including applying patches, updates, and security configurations. AWS manages the underlying infrastructure, but the customer maintains the OS and applications on the instance.',
            'sort_order' => 152,
        ]);

        $set->questions()->create([
            'question' => "Question 153\n\nA company needs to run an application on Amazon EC2 instances without interruption.\n\nWhich EC2 instance purchasing option will meet this requirement MOST cost-effectively?",
            'options' => [
                'Standard Reserved Instances',
                'Convertible Reserved Instances',
                'On-Demand Instances',
                'Spot Instances',
            ],
            'correct_answer' => 'Standard Reserved Instances',
            'explanation' => 'Standard Reserved Instances provide the largest discount among the non-interruptible EC2 purchasing options for predictable, long-term workloads. They are generally more cost-effective than On-Demand Instances and less flexible than Convertible Reserved Instances, while Spot Instances can be interrupted.',
            'sort_order' => 153,
        ]);

        $set->questions()->create([
            'question' => "Question 154\n\nA company wants to deploy a non-containerized Java-based web application on AWS. The company wants to use a managed service to quickly deploy the application. The company wants the service to automatically provision capacity, load balance, scale, and monitor application health.\n\nWhich AWS service will meet these requirements?",
            'options' => [
                'Amazon Elastic Container Service (Amazon ECS)',
                'AWS Lambda',
                'Amazon Elastic Kubernetes Service (Amazon EKS)',
                'AWS Elastic Beanstalk',
            ],
            'correct_answer' => 'AWS Elastic Beanstalk',
            'explanation' => 'AWS Elastic Beanstalk is a managed service for quickly deploying and running web applications, including Java applications. It automatically handles infrastructure provisioning, load balancing, automatic scaling, deployment, and application health monitoring.',
            'sort_order' => 154,
        ]);

        $set->questions()->create([
            'question' => "Question 155\n\nA company wants to migrate its containerized workload from an on-premises data center to a managed container service in the AWS Cloud.\n\nWhich AWS services should the company use? (Choose two.)",
            'options' => [
                'Amazon EC2',
                'Amazon Elastic Kubernetes Service (Amazon EKS)',
                'Amazon Elastic Container Registry (Amazon ECR)',
                'Amazon Elastic Container Service (Amazon ECS)',
                'AWS Lambda',
            ],
            'correct_answer' => '[1,2]',
            'explanation' => 'Amazon EKS is a fully managed Kubernetes service for running containerized workloads on AWS, and Amazon ECR is a fully managed container registry for storing and deploying container images. Together they support migrating and operating containerized applications in AWS.',
            'sort_order' => 155,
        ]);

        $set->questions()->create([
            'question' => "Question 156\n\nA company is using AWS Identity and Access Management (IAM).\n\nWho can manage the access keys of the AWS account root user?",
            'options' => [
                'IAM users in the same account that have been granted permission',
                'IAM roles in any account that have been granted permission',
                'IAM users and roles that have been granted permission',
                'The AWS account owner',
            ],
            'correct_answer' => 'The AWS account owner',
            'explanation' => 'Only the AWS account owner can manage the access keys of the AWS account root user. IAM users and IAM roles cannot manage the root user\'s credentials, even if they have administrative permissions.',
            'sort_order' => 156,
        ]);

        $set->questions()->create([
            'question' => "Question 157\n\nA company has data lakes designed for high performance computing (HPC) workloads.\n\nWhich Amazon EC2 instance type should the company use to meet these requirements?",
            'options' => [
                'General purpose instances',
                'Compute optimized instances',
                'Memory optimized instances',
                'Storage optimized instances',
            ],
            'correct_answer' => 'Compute optimized instances',
            'explanation' => 'Compute optimized instances provide high-performance processors and are designed for compute-intensive workloads such as HPC, scientific modeling, batch processing, and other applications that need significant CPU resources.',
            'sort_order' => 157,
        ]);

        $set->questions()->create([
            'question' => "Question 158\n\nA company stores data in an Amazon S3 bucket.\n\nWhich task is the responsibility of AWS?",
            'options' => [
                'Configure an S3 Lifecycle policy.',
                'Activate S3 Versioning.',
                'Configure S3 bucket policies.',
                'Protect the infrastructure that supports S3 storage.',
            ],
            'correct_answer' => 'Protect the infrastructure that supports S3 storage.',
            'explanation' => 'Under the AWS shared responsibility model, AWS is responsible for security of the cloud, including the physical facilities, hardware, networking, and infrastructure that support Amazon S3. Customers are responsible for configuring lifecycle policies, versioning, bucket policies, and protecting their data.',
            'sort_order' => 158,
        ]);

        $set->questions()->create([
            'question' => "Question 159\n\nA company wants to avoid unnecessary charges and run workloads at the lowest price point.\n\nWhich pillar of the AWS Well-Architected Framework includes these goals?",
            'options' => [
                'Security',
                'Reliability',
                'Sustainability',
                'Cost optimization',
            ],
            'correct_answer' => 'Cost optimization',
            'explanation' => 'The Cost Optimization pillar focuses on managing and reducing AWS costs. It helps companies avoid unnecessary charges by using resources efficiently, selecting appropriate pricing models, and continuously optimizing workloads to run at the lowest practical cost.',
            'sort_order' => 159,
        ]);

        $set->questions()->create([
            'question' => "Question 160\n\nA company wants to securely access an Amazon S3 bucket from an Amazon EC2 instance without accessing the internet.\n\nWhat should the company use to accomplish this goal?",
            'options' => [
                'VPN connection',
                'Internet gateway',
                'VPC endpoint',
                'NAT gateway',
            ],
            'correct_answer' => 'VPC endpoint',
            'explanation' => 'A VPC endpoint allows an EC2 instance inside a VPC to connect privately to Amazon S3 without using an internet gateway, NAT gateway, VPN connection, or public IP address. The traffic remains on the AWS network, which improves security.',
            'sort_order' => 160,
        ]);

        $set->questions()->create([
            'question' => "Question 161\n\nA company is migrating its public website to AWS. The company wants to host the domain name for the website on AWS.\n\nWhich AWS service should the company use to meet this requirement?",
            'options' => [
                'AWS Lambda',
                'Amazon Route 53',
                'Amazon CloudFront',
                'AWS Direct Connect',
            ],
            'correct_answer' => 'Amazon Route 53',
            'explanation' => 'Amazon Route 53 is a scalable DNS service that can register and host domain names and route users to websites and applications running on AWS or in other environments.',
            'sort_order' => 161,
        ]);

        $set->questions()->create([
            'question' => "Question 162\n\nA company needs to perform a one-time migration of 50 TB of data from on-premises storage to AWS.\n\nWhich AWS service will meet this requirement with the LEAST operational overhead?",
            'options' => [
                'Amazon S3',
                'AWS Snowball Edge',
                'AWS Database Migration Service (AWS DMS)',
                'Amazon Elastic Block Store (Amazon EBS)',
            ],
            'correct_answer' => 'AWS Snowball Edge',
            'explanation' => 'AWS Snowball Edge is a physical device designed to transfer large amounts of data from on premises to AWS. For a one-time 50 TB migration, it avoids sending the dataset over the internet and minimizes operational effort.',
            'sort_order' => 162,
        ]);

        $set->questions()->create([
            'question' => "Question 163\n\nWhich AWS Cloud Adoption Framework (AWS CAF) capability belongs to the business perspective?",
            'options' => [
                'Program and project management',
                'Data science',
                'Observability',
                'Change and release management',
            ],
            'correct_answer' => 'Data science',
            'explanation' => 'In this question set, data science is treated as a capability in the AWS CAF business perspective because it helps organizations use data, analytics, and machine learning to generate business insights and measurable value.',
            'sort_order' => 163,
        ]);

        $set->questions()->create([
            'question' => "Question 164\n\nA company wants to track the monthly cost and usage of all Amazon EC2 instances in a specific AWS environment.\n\nWhich AWS service or tool will meet these requirements?",
            'options' => [
                'AWS Cost Anomaly Detection',
                'AWS Budgets',
                'AWS Compute Optimizer',
                'AWS Trusted Advisor',
            ],
            'correct_answer' => 'AWS Budgets',
            'explanation' => 'AWS Budgets enables a company to track monthly AWS costs and usage, including the costs and usage of Amazon EC2 instances. It can also send alerts when actual or forecasted spending exceeds a specified budget.',
            'sort_order' => 164,
        ]);

        $set->questions()->create([
            'question' => "Question 165\n\nWhich Reserved Instance (RI) provides the HIGHEST average cost savings compared to an On-Demand Instance?",
            'options' => [
                '1-year, No Upfront, Standard RI',
                '1-year, All Upfront, Convertible RI',
                '3-year, All Upfront, Standard RI',
                '3-year, No Upfront, Convertible RI',
            ],
            'correct_answer' => '3-year, All Upfront, Standard RI',
            'explanation' => 'A 3-year, All Upfront, Standard Reserved Instance generally provides the highest average cost savings compared with On-Demand pricing because Standard RIs offer deeper discounts, all-upfront payment maximizes savings, and a 3-year term discounts more than a 1-year term.',
            'sort_order' => 165,
        ]);

        $set->questions()->create([
            'question' => "Question 166\n\nWhich AWS service provides recommendations to help users reduce the cost of Amazon EC2 instances?",
            'options' => [
                'AWS AppConfig',
                'AWS Control Tower',
                'AWS AppSync',
                'AWS Compute Optimizer',
            ],
            'correct_answer' => 'AWS Compute Optimizer',
            'explanation' => 'AWS Compute Optimizer analyzes the usage of Amazon EC2 instances and other AWS resources and provides actionable recommendations to reduce costs by optimizing instance types, sizes, and configurations.',
            'sort_order' => 166,
        ]);

        $set->questions()->create([
            'question' => "Question 167\n\nA company needs to use Amazon S3 to store audio files that are each 5 megabytes in size. The company will rarely access the files, but the company must be able to retrieve the files immediately.\n\nWhich S3 storage class will meet these requirements MOST cost-effectively?",
            'options' => [
                'S3 Standard',
                'S3 Standard-Infrequent Access (S3 Standard-IA)',
                'S3 Glacier Flexible Retrieval',
                'S3 Glacier Deep Archive',
            ],
            'correct_answer' => 'S3 Standard-Infrequent Access (S3 Standard-IA)',
            'explanation' => 'S3 Standard-IA is designed for data that is accessed infrequently but still needs immediate retrieval. It provides lower storage costs than S3 Standard while keeping millisecond access to the files.',
            'sort_order' => 167,
        ]);

        $set->questions()->create([
            'question' => "Question 168\n\nA company has a MariaDB database on premises. The company wants to move the data to the AWS Cloud.\n\nWhich AWS service will host this database with the LEAST amount of operational overhead?",
            'options' => [
                'Amazon RDS',
                'Amazon Neptune',
                'Amazon S3',
                'Amazon DynamoDB',
            ],
            'correct_answer' => 'Amazon RDS',
            'explanation' => 'Amazon RDS is a managed relational database service that supports MariaDB. It reduces operational overhead by handling tasks such as hardware provisioning, database setup, patching, backups, and maintenance.',
            'sort_order' => 168,
        ]);

        $set->questions()->create([
            'question' => "Question 169\n\nWhich AWS service is designed to help users handle large amounts of data in a data warehouse environment?",
            'options' => [
                'Amazon RDS',
                'Amazon DynamoDB',
                'Amazon Redshift',
                'Amazon Aurora',
            ],
            'correct_answer' => 'Amazon Redshift',
            'explanation' => 'Amazon Redshift is a fully managed cloud data warehouse service that is designed to store and analyze large amounts of data. It is optimized for complex analytical queries in data warehouse environments.',
            'sort_order' => 169,
        ]);

        $set->questions()->create([
            'question' => "Question 170\n\nWhich AWS service monitors AWS accounts for security threats?",
            'options' => [
                'Amazon GuardDuty',
                'AWS Secrets Manager',
                'Amazon Cognito',
                'AWS Certificate Manager (ACM)',
            ],
            'correct_answer' => 'Amazon GuardDuty',
            'explanation' => 'Amazon GuardDuty is a threat detection service that continuously monitors AWS accounts and workloads for malicious or unauthorized activity. It analyzes signals from sources such as VPC Flow Logs, AWS CloudTrail event logs, and DNS logs to identify potential security threats.',
            'sort_order' => 170,
        ]);

        $set->questions()->create([
            'question' => "Question 171\n\nA company wants to use an AWS networking solution that can act as a centralized gateway between multiple VPCs and on-premises networks.\n\nWhich AWS service or feature will meet this requirement?",
            'options' => [
                'Gateway VPC endpoint',
                'AWS Direct Connect',
                'AWS Transit Gateway',
                'AWS PrivateLink',
            ],
            'correct_answer' => 'AWS Transit Gateway',
            'explanation' => 'AWS Transit Gateway acts as a centralized gateway that connects multiple VPCs and on-premises networks. It simplifies network management by allowing connected networks to communicate through a single central gateway.',
            'sort_order' => 171,
        ]);

        $set->questions()->create([
            'question' => "Question 172\n\nA company plans to migrate on-premises Internet Small Computer Systems Interface (iSCSI) storage to AWS. The company needs low-latency access to the stored data. The company also must minimize infrastructure changes to workloads that use the storage.\n\nWhich AWS storage solution will meet these requirements?",
            'options' => [
                'Amazon Elastic Block Store (Amazon EBS)',
                'Amazon S3 File Gateway',
                'AWS Storage Gateway Tape Gateway',
                'AWS Storage Gateway Volume Gateway',
            ],
            'correct_answer' => 'AWS Storage Gateway Volume Gateway',
            'explanation' => 'AWS Storage Gateway Volume Gateway supports the iSCSI protocol and provides low-latency access to frequently used data while using cloud-backed storage. It helps migrate on-premises iSCSI-based workloads to AWS with minimal application and infrastructure changes.',
            'sort_order' => 172,
        ]);

        $set->questions()->create([
            'question' => "Question 173\n\nWhich of the following are pillars of the AWS Well-Architected Framework? (Choose two.)",
            'options' => [
                'Resource scalability',
                'Performance efficiency',
                'System elasticity',
                'Agile development',
                'Operational excellence',
            ],
            'correct_answer' => '[1,4]',
            'explanation' => 'Performance efficiency and operational excellence are pillars of the AWS Well-Architected Framework. Performance efficiency focuses on using computing resources efficiently, while operational excellence focuses on running, monitoring, and continuously improving systems and processes.',
            'sort_order' => 173,
        ]);

        $set->questions()->create([
            'question' => "Question 174\n\nA company needs to use an offline transfer strategy to move petabytes of databases, backups, and data records from on premises to the AWS Cloud.\n\nWhich solution will meet this requirement with the MOST operational efficiency?",
            'options' => [
                'AWS Snowball Edge compute-optimized devices',
                'AWS Snowcone devices',
                'AWS Storage Gateway',
                'AWS DataSync',
            ],
            'correct_answer' => 'AWS Snowball Edge compute-optimized devices',
            'explanation' => 'AWS Snowball Edge compute-optimized devices are designed for large-scale offline data transfers to AWS. They are suitable for transferring petabytes of data and can provide additional compute capabilities to process data before or during transfer, which makes them operationally efficient for very large migrations.',
            'sort_order' => 174,
        ]);

        $set->questions()->create([
            'question' => "Question 175\n\nA company wants to manage access and permissions for its third-party software as a service (SaaS) applications. The company wants to use a portal where end users can access assigned AWS accounts and AWS Cloud applications.\n\nWhich AWS service should the company use to meet these requirements?",
            'options' => [
                'Amazon Cognito',
                'AWS IAM Identity Center (AWS Single Sign-On)',
                'AWS Identity and Access Management (IAM)',
                'AWS Directory Service for Microsoft Active Directory',
            ],
            'correct_answer' => 'AWS IAM Identity Center (AWS Single Sign-On)',
            'explanation' => 'AWS IAM Identity Center provides centralized access management for multiple AWS accounts and third-party SaaS applications. It offers a single portal where users can access assigned AWS accounts and cloud applications by using single sign-on.',
            'sort_order' => 175,
        ]);

        $set->questions()->create([
            'question' => "Question 176\n\nA company wants to manage its cloud resources by using infrastructure as code (IaC) templates. The company needs to meet compliance requirements.\n\nWhich AWS service should the company use to meet these requirements?",
            'options' => [
                'AWS Artifact',
                'AWS Resource Explorer',
                'AWS License Manager',
                'AWS Service Catalog',
            ],
            'correct_answer' => 'AWS Service Catalog',
            'explanation' => 'AWS Service Catalog allows organizations to create, manage, and distribute approved collections of cloud resources by using infrastructure as code templates. It helps ensure that users deploy only standardized and compliant resources.',
            'sort_order' => 176,
        ]);

        $set->questions()->create([
            'question' => "Question 177\n\nA company has an application workload that is mostly consistent. However, the workload requires access to additional capacity during unpredictable peaks in demand. The workload must run for 1 year and cannot be interrupted.\n\nWhich purchasing option will meet these requirements MOST cost-effectively?",
            'options' => [
                'Use Spot Instances for the entire workload.',
                'Use On-Demand Instances for the entire workload.',
                'Use On-Demand Instances for consistent baseline compute capacity. Use Spot Instances for additional burst capacity.',
                'Use Compute Savings Plans for consistent baseline compute capacity. Use On-Demand Instances for additional burst capacity.',
            ],
            'correct_answer' => 'Use Compute Savings Plans for consistent baseline compute capacity. Use On-Demand Instances for additional burst capacity.',
            'explanation' => 'Compute Savings Plans are cost-effective for consistent baseline compute capacity over a 1-year term while still allowing flexibility across instance types and sizes. For unpredictable peaks, On-Demand Instances provide additional non-interruptible capacity without long-term commitment.',
            'sort_order' => 177,
        ]);

        $set->questions()->create([
            'question' => "Question 178\n\nA company needs to use an AWS service to invoke an AWS Lambda function when an Amazon EC2 instance enters the stopping state.\n\nWhich AWS service will meet this requirement?",
            'options' => [
                'Amazon EventBridge',
                'AWS Config',
                'Amazon Simple Notification Service (Amazon SNS)',
                'AWS CloudFormation',
            ],
            'correct_answer' => 'Amazon EventBridge',
            'explanation' => 'Amazon EventBridge can detect changes in the state of an Amazon EC2 instance. An EventBridge rule can be configured to invoke an AWS Lambda function automatically when the instance enters the stopping state.',
            'sort_order' => 178,
        ]);

        $set->questions()->create([
            'question' => "Question 179\n\nWhich of the following are advantages of moving to the AWS Cloud? (Choose two.)",
            'options' => [
                'Users can implement all AWS services in seconds.',
                'AWS assumes all responsibility for the security of infrastructure and applications.',
                'Users experience increased speed and agility.',
                'Users benefit from massive economies of scale.',
                'Users can move hardware from their data center to the AWS Cloud.',
            ],
            'correct_answer' => '[2,3]',
            'explanation' => 'Moving to the AWS Cloud increases speed and agility because users can quickly provision and scale resources. Users also benefit from AWS\'s massive economies of scale, which can help reduce costs through efficient, pay-as-you-go consumption.',
            'sort_order' => 179,
        ]);

        $set->questions()->create([
            'question' => "Question 180\n\nA company wants to build graph queries for real-time fraud pattern detection.\n\nWhich AWS service will meet this requirement?",
            'options' => [
                'Amazon Neptune',
                'Amazon DynamoDB',
                'Amazon Timestream',
                'Amazon Forecast',
            ],
            'correct_answer' => 'Amazon Neptune',
            'explanation' => 'Amazon Neptune is a fully managed graph database service designed to store and query highly connected data. It can analyze relationships between transactions, accounts, and users, which makes it suitable for detecting fraud patterns in real time.',
            'sort_order' => 180,
        ]);

        $set->questions()->create([
            'question' => "Question 181\n\nA company has a workload that will run continuously for 1 year. The workload cannot tolerate service interruptions.\n\nWhich Amazon EC2 purchasing option will be MOST cost-effective?",
            'options' => [
                'All Upfront Reserved Instances',
                'Partial Upfront Reserved Instances',
                'Dedicated Instances',
                'On-Demand Instances',
            ],
            'correct_answer' => 'All Upfront Reserved Instances',
            'explanation' => 'All Upfront Reserved Instances provide the highest discount for a predictable workload that runs continuously for 1 year. They are not interruptible like Spot Instances, and paying fully upfront generally results in a lower total cost than Partial Upfront or On-Demand pricing.',
            'sort_order' => 181,
        ]);

        $set->questions()->create([
            'question' => "Question 182\n\nA company plans to launch an ecommerce website that contains many images for a product catalog. The company wants to keep the cost of running the website within a specific budget.\n\nWhich AWS service or tool should the company use to monitor the ongoing costs of the website?",
            'options' => [
                'AWS Cost Explorer',
                'AWS SDKs',
                'EC2 Image Builder',
                'AWS CloudFormation',
            ],
            'correct_answer' => 'AWS Cost Explorer',
            'explanation' => 'AWS Cost Explorer helps companies view, monitor, and analyze AWS costs and usage over time. It can be used to understand spending patterns and track whether the website\'s ongoing costs remain within budget.',
            'sort_order' => 182,
        ]);

        $set->questions()->create([
            'question' => "Question 183\n\nA company is designing an identity access management solution for an application. The company wants users to be able to use their social media, email, or online shopping accounts to access the application.\n\nWhich AWS service provides this functionality?",
            'options' => [
                'AWS IAM Identity Center',
                'AWS Config',
                'Amazon Cognito',
                'AWS Identity and Access Management (IAM)',
            ],
            'correct_answer' => 'Amazon Cognito',
            'explanation' => 'Amazon Cognito provides user authentication and identity management for applications. It supports federated identities so users can sign in with existing social media, email, or online shopping accounts such as Google, Facebook, and Amazon.',
            'sort_order' => 183,
        ]);
        $set->questions()->create([
            'question' => "Question 184\n\nA company has deployed several public applications behind Application Load Balancers. The company wants to improve the performance of the applications.\n\nWhich AWS service will meet these requirements?",
            'options' => [
                'AWS Global Accelerator',
                'Amazon Connect',
                'Amazon ElastiCache',
                'Amazon CloudWatch',
            ],
            'correct_answer' => 'AWS Global Accelerator',
            'explanation' => 'AWS Global Accelerator improves the performance and availability of public applications by routing user traffic through the AWS global network. It can use Application Load Balancers as endpoints and direct users to the optimal endpoint with lower latency.',
            'sort_order' => 184,
        ]);
        $set->questions()->create([
            'question' => "Question 185\n\nA company has a compliance requirement to record and evaluate configuration changes, as well as perform remediation actions on AWS resources.\n\nWhich AWS service should the company use?",
            'options' => [
                'AWS Config',
                'AWS Secrets Manager',
                'AWS CloudTrail',
                'AWS Trusted Advisor',
            ],
            'correct_answer' => 'AWS Config',
            'explanation' => 'AWS Config records and evaluates changes to AWS resource configurations. It uses AWS Config rules to check resources against compliance requirements and can perform automatic remediation actions on noncompliant resources.',
            'sort_order' => 185,
        ]);

        $set->questions()->create([
            'question' => "Question 186\n\nA company needs to check for IAM access keys that have not been rotated recently.\n\nWhich AWS service should the company use to meet this requirement?",
            'options' => [
                'AWS Shield',
                'AWS Service Catalog',
                'AWS Trusted Advisor',
                'AWS Certificate Manager (ACM)',
            ],
            'correct_answer' => 'AWS Trusted Advisor',
            'explanation' => 'AWS Trusted Advisor provides insights and recommendations to improve the performance, security, and cost-effectiveness of an AWS environment. Its security checks can identify IAM access keys that have not been rotated recently, helping organizations follow security best practices.',
            'sort_order' => 186,
        ]);

        $set->questions()->create([
            'question' => "Question 187\n\nWhich AWS service or feature can a company use to determine which business unit is using specific AWS resources?",
            'options' => [
                'Cost allocation tags',
                'Key pairs',
                'Amazon Inspector',
                'AWS Trusted Advisor',
            ],
            'correct_answer' => 'Cost allocation tags',
            'explanation' => 'Cost allocation tags allow companies to assign metadata to AWS resources to identify and organize them. By using these tags, businesses can categorize resources by business units, projects, or departments and analyze the costs associated with each category, making it easier to track and manage expenses.',
            'sort_order' => 187,
        ]);

        $set->questions()->create([
            'question' => "Question 188\n\nA company wants to store its files in the AWS Cloud. Users need to be able to download these files directly using a public URL.\n\nWhich AWS service or feature will meet this requirement?",
            'options' => [
                'Amazon Redshift',
                'Amazon Elastic Block Store (Amazon EBS)',
                'Amazon Elastic File System (Amazon EFS)',
                'Amazon S3',
            ],
            'correct_answer' => 'Amazon S3',
            'explanation' => 'Amazon S3 is an object storage service that stores files as objects. S3 objects can be made publicly accessible and downloaded directly through a public URL.',
            'sort_order' => 188,
        ]);

        $set->questions()->create([
            'question' => "Question 189\n\nA company needs a firewall that will control network connections to and from a single Amazon EC2 instance. This firewall will not control network connections to and from other instances that are in the same subnet.\n\nWhich AWS service or feature can the company use to meet these requirements?",
            'options' => [
                'Network ACL',
                'AWS WAF',
                'Route table',
                'Security group',
            ],
            'correct_answer' => 'Security group',
            'explanation' => 'A security group acts as a virtual firewall for individual Amazon EC2 instances. It controls inbound and outbound traffic for the associated instance without affecting other instances in the same subnet.',
            'sort_order' => 189,
        ]);

        $set->questions()->create([
            'question' => "Question 190\n\nA company needs to run some of its workloads on premises to comply with regulatory guidelines. The company wants to use the AWS Cloud to run workloads that are not required to be on premises. The company also wants to be able to use the same API calls for the on-premises workloads and the cloud workloads.\n\nWhich AWS service or feature should the company use to meet these requirements?",
            'options' => [
                'Dedicated Hosts',
                'AWS Outposts',
                'Availability Zones',
                'AWS Wavelength',
            ],
            'correct_answer' => 'AWS Outposts',
            'explanation' => 'AWS Outposts extends AWS infrastructure and services to an on-premises location. It allows the company to run workloads both on premises and in the AWS Cloud by using the same AWS APIs, tools, and management processes.',
            'sort_order' => 190,
        ]);

        $set->questions()->create([
            'question' => "Question 191\n\nA company wants to run its application's code without having to provision and manage servers.\n\nWhich AWS service will meet this requirement?",
            'options' => [
                'AWS Glue',
                'AWS Lambda',
                'AWS CodeDeploy',
                'Amazon CodeGuru',
            ],
            'correct_answer' => 'AWS Lambda',
            'explanation' => 'AWS Lambda is a serverless compute service that runs application code without requiring users to provision or manage servers. It automatically manages the underlying infrastructure and scales according to demand.',
            'sort_order' => 191,
        ]);

        $set->questions()->create([
            'question' => "Question 192\n\nA company is running Amazon EC2 instances in a private subnet in a VPC.\n\nWhich AWS service or feature can provide the EC2 instances with network connections to the internet?",
            'options' => [
                'Gateway endpoint',
                'NAT gateway',
                'Network Load Balancer',
                'Amazon Route 53',
            ],
            'correct_answer' => 'NAT gateway',
            'explanation' => 'A NAT gateway (Network Address Translation gateway) allows EC2 instances in a private subnet to initiate outbound connections to the internet while preventing inbound internet connections from directly reaching those instances. It is commonly used to provide private-subnet instances with secure internet access.',
            'sort_order' => 192,
        ]);

        $set->questions()->create([
            'question' => "Question 193\n\nWhich statements accurately describe the relationships among components of AWS global infrastructure? (Choose two.)",
            'options' => [
                'There are more AWS Regions than Availability Zones.',
                'There are more edge locations than AWS Regions.',
                'An edge location is an Availability Zone.',
                'There are more AWS Regions than edge locations.',
                'There are more Availability Zones than AWS Regions.',
            ],
            'correct_answer' => '[1,4]',
            'explanation' => 'Each AWS Region contains multiple Availability Zones, so there are more Availability Zones than AWS Regions. AWS also operates many edge locations worldwide to deliver content with low latency, so there are more edge locations than AWS Regions.',
            'sort_order' => 193,
        ]);

        $set->questions()->create([
            'question' => "Question 194\n\nWhich AWS service or tool can a company use to set up consolidated billing?",
            'options' => [
                'AWS Billing and Cost Management console',
                'AWS Organizations',
                'AWS Cost and Usage Report',
                'AWS Systems Manager',
            ],
            'correct_answer' => 'AWS Organizations',
            'explanation' => 'AWS Organizations allows a company to set up consolidated billing for multiple AWS accounts. The company can link multiple accounts within an organization and receive a single combined bill through the management account. This simplifies billing, payment management, and cost allocation across accounts.',
            'sort_order' => 194,
        ]);

        $set->questions()->create([
            'question' => "Question 195\n\nA company wants to deploy its critical application on AWS and maintain high availability.\n\nHow should the company deploy the application to meet these requirements?",
            'options' => [
                'In a single Availability Zone',
                'On AWS Direct Connect',
                'On Reserved Instances',
                'In multiple Availability Zones',
            ],
            'correct_answer' => 'In multiple Availability Zones',
            'explanation' => 'Deploying the application in multiple Availability Zones (AZs) ensures high availability. By distributing resources across different AZs, the application can continue operating if a single AZ fails, which minimizes downtime and maintains reliability for critical applications.',
            'sort_order' => 195,
        ]);

        $set->questions()->create([
            'question' => "Question 196\n\nWhich AWS service keeps track of SSL/TLS certificates, creates new certificates, and processes renewals?",
            'options' => [
                'AWS Identity and Access Management (IAM)',
                'AWS Certificate Manager (ACM)',
                'AWS Config',
                'AWS Trusted Advisor',
            ],
            'correct_answer' => 'AWS Certificate Manager (ACM)',
            'explanation' => 'AWS Certificate Manager (ACM) simplifies the management of SSL/TLS certificates for AWS resources. It handles certificate provisioning, deployment, tracking, and automatic renewal, reducing the need for manual certificate management.',
            'sort_order' => 196,
        ]);

        $set->questions()->create([
            'question' => "Question 197\n\nA company is planning to move data backups to the AWS Cloud. The company needs to replace on-premises storage with storage that is cloud-based but locally cached.\n\nWhich AWS service meets these requirements?",
            'options' => [
                'AWS Storage Gateway',
                'AWS Snowcone',
                'AWS Backup',
                'Amazon Elastic File System (Amazon EFS)',
            ],
            'correct_answer' => 'AWS Storage Gateway',
            'explanation' => 'AWS Storage Gateway connects on-premises environments to cloud-based storage. It stores data securely in AWS while keeping frequently accessed data in a local cache, providing low-latency access for on-premises applications.',
            'sort_order' => 197,
        ]);

        $set->questions()->create([
            'question' => "Question 198\n\nA company needs to run a workload for several batch image rendering applications. It is acceptable for the workload to experience downtime.\n\nWhich Amazon EC2 pricing model would be MOST cost-effective in this situation?",
            'options' => [
                'On-Demand Instances',
                'Reserved Instances',
                'Dedicated Instances',
                'Spot Instances',
            ],
            'correct_answer' => 'Spot Instances',
            'explanation' => 'Spot Instances are the most cost-effective option for workloads that can tolerate interruptions or downtime. They provide unused Amazon EC2 capacity at a significantly reduced price, making them ideal for batch processing, image rendering, and other flexible, fault-tolerant workloads.',
            'sort_order' => 198,
        ]);

        $set->questions()->create([
            'question' => "Question 199\n\nA company seeks cost savings in exchange for a commitment to use a specific amount of an AWS service or category of AWS services for 1 year or 3 years.\n\nWhich AWS pricing model or offering will meet these requirements?",
            'options' => [
                'Pay-as-you-go pricing',
                'Savings Plans',
                'AWS Free Tier',
                'Volume discounts',
            ],
            'correct_answer' => 'Savings Plans',
            'explanation' => 'Savings Plans provide cost savings in exchange for a commitment to use a specific amount of eligible AWS services for a 1-year or 3-year term. They apply to services such as Amazon EC2, AWS Lambda, and AWS Fargate while providing flexibility in how the services are used.',
            'sort_order' => 199,
        ]);

        $set->questions()->create([
            'question' => "Question 200\n\nA company wants to purchase Amazon EC2 instances before using the EC2 instances for a workload. The company will commit to use the EC2 instances at a particular price over a specific period of time.\n\nWhich AWS pricing model will meet these requirements MOST cost-effectively?",
            'options' => [
                'On-Demand Instances',
                'Dedicated Hosts',
                'Reserved Instances',
                'Spot Instances',
            ],
            'correct_answer' => 'Reserved Instances',
            'explanation' => 'Reserved Instances (RIs) allow a company to commit to using Amazon EC2 instances for a specific period of time, typically 1 or 3 years, at a discounted price compared to On-Demand pricing. This pricing model is cost-effective for predictable workloads that can commit to long-term EC2 usage.',
            'sort_order' => 200,
        ]);

        $set->questions()->create([
            'question' => "Question 201\n\nA company has a centralized group of users with large file storage requirements that have exceeded the space available on premises. The company wants to extend its file storage capabilities for this group while retaining the performance benefit of sharing content locally.\n\nWhat is the MOST operationally efficient AWS solution for this scenario?",
            'options' => [
                'Create an Amazon S3 bucket for each user. Mount each bucket by using an S3 file system mounting utility.',
                'Configure and deploy an AWS Storage Gateway file gateway. Connect each user\'s workstation to the file gateway.',
                'Move each user\'s working environment to Amazon WorkSpaces. Set up an Amazon WorkDocs account for each user.',
                'Deploy an Amazon EC2 instance and attach an Amazon Elastic Block Store (Amazon EBS) Provisioned IOPS volume. Share the EBS volume directly with the users.',
            ],
            'correct_answer' => 'Configure and deploy an AWS Storage Gateway file gateway. Connect each user\'s workstation to the file gateway.',
            'explanation' => 'AWS Storage Gateway File Gateway provides on-premises users with standard file-sharing access while storing files in Amazon S3. It maintains a local cache of frequently accessed data, providing low-latency local performance while extending storage capacity to the AWS Cloud.',
            'sort_order' => 201,
        ]);

        $set->questions()->create([
            'question' => "Question 202\n\nWhich feature of Amazon RDS provides the ability to automatically create a primary database instance and to synchronously replicate data to an instance in another Availability Zone?",
            'options' => [
                'Read replicas',
                'Blue/green deployment',
                'Multi-AZ deployment',
                'Reserved Instances',
            ],
            'correct_answer' => 'Multi-AZ deployment',
            'explanation' => 'Amazon RDS Multi-AZ deployment creates a primary database instance and synchronously replicates its data to a standby instance in another Availability Zone. If the primary instance fails, Amazon RDS can automatically fail over to the standby instance to provide high availability.',
            'sort_order' => 202,
        ]);

        $set->questions()->create([
            'question' => "Question 203\n\nA company must archive its documents by using a write-once, read-many (WORM) model to meet legal and compliance obligations.\n\nWhich feature of Amazon S3 can the company use to meet this requirement?",
            'options' => [
                'S3 Versioning',
                'S3 bucket policy',
                'S3 Glacier Vault Lock',
                'S3 multi-factor authentication (MFA) delete',
            ],
            'correct_answer' => 'S3 Glacier Vault Lock',
            'explanation' => 'S3 Glacier Vault Lock allows a company to enforce write-once, read-many (WORM) controls by locking a vault access policy. This prevents archived documents from being modified or deleted during the required retention period and helps meet legal and compliance obligations.',
            'sort_order' => 203,
        ]);

        $set->questions()->create([
            'question' => "Question 204\n\nA company has deployed a web application to Amazon EC2 instances. The EC2 instances have low usage.\n\nWhich AWS service or feature should the company use to rightsize the EC2 instances?",
            'options' => [
                'AWS Config',
                'AWS Cost Anomaly Detection',
                'AWS Budgets',
                'AWS Compute Optimizer',
            ],
            'correct_answer' => 'AWS Compute Optimizer',
            'explanation' => 'AWS Compute Optimizer analyzes the utilization metrics of Amazon EC2 instances and provides rightsizing recommendations. It helps identify over-provisioned instances and recommends suitable instance types to improve performance and reduce costs.',
            'sort_order' => 204,
        ]);

        $set->questions()->create([
            'question' => "Question 205\n\nA company runs workloads on AWS to provide real-time gaming and augmented virtual reality platforms to users. The company wants to ensure that the users can run apps with single-digit millisecond latencies on their mobile devices.\n\nWhich AWS solution can the company use for deployment to meet these requirements?",
            'options' => [
                'Provisioned IOPS',
                'AWS Graviton processors',
                'AWS Wavelength',
                'AWS Outposts',
            ],
            'correct_answer' => 'AWS Wavelength',
            'explanation' => 'AWS Wavelength embeds AWS compute and storage services within telecommunications providers\' 5G networks. It is designed for ultra-low-latency mobile applications, such as real-time gaming and augmented reality, that require single-digit millisecond latency.',
            'sort_order' => 205,
        ]);

        $set->questions()->create([
            'question' => "Question 206\n\nTo assist companies with Payment Card Industry Data Security Standard (PCI DSS) compliance in the cloud, AWS provides:",
            'options' => [
                'Physical inspections of data centers by appointment.',
                'Required PCI compliance certifications for any application running on AWS.',
                'An AWS Attestation of Compliance (AOC) report for specific AWS services.',
                'Professional PCI compliance services.',
            ],
            'correct_answer' => 'An AWS Attestation of Compliance (AOC) report for specific AWS services.',
            'explanation' => 'AWS provides an Attestation of Compliance (AOC) report for AWS services that are within the scope of PCI DSS. Customers can use this report as supporting documentation when assessing and demonstrating the compliance of their workloads.',
            'sort_order' => 206,
        ]);

        $set->questions()->create([
            'question' => "Question 207\n\nWhich AWS service can report how AWS resource configurations have changed over time?",
            'options' => [
                'AWS CloudTrail',
                'Amazon CloudWatch',
                'AWS Config',
                'Amazon Inspector',
            ],
            'correct_answer' => 'AWS Config',
            'explanation' => 'AWS Config tracks and records changes to AWS resource configurations over time. It allows users to monitor, evaluate, and audit resource configurations and provides a detailed history of configuration changes.',
            'sort_order' => 207,
        ]);

        $set->questions()->create([
            'question' => "Question 208\n\nA company is running an application on AWS. The company wants to protect the application\'s resources from DDoS attacks. The company also wants to receive a service credit if a DDoS attack increases the utilization of the protected resources.\n\nWhich AWS solution will meet these requirements?",
            'options' => [
                'Amazon GuardDuty',
                'AWS Shield Advanced',
                'AWS Shield Standard',
                'AWS WAF',
            ],
            'correct_answer' => 'AWS Shield Advanced',
            'explanation' => 'AWS Shield Advanced provides enhanced protection against DDoS attacks. It includes 24/7 access to the AWS Shield Response Team and cost protection that can provide service credits for eligible scaling charges caused by a DDoS attack.',
            'sort_order' => 208,
        ]);

        $set->questions()->create([
            'question' => "Question 209\n\nWhich AWS service can generate information that can be used by external auditors?",
            'options' => [
                'Amazon Cognito',
                'Amazon FSx',
                'AWS Config',
                'Amazon Inspector',
            ],
            'correct_answer' => 'AWS Config',
            'explanation' => 'AWS Config records AWS resource configurations and tracks configuration changes over time. It can generate configuration history and compliance information that external auditors can use to evaluate whether resources meet organizational and regulatory requirements.',
            'sort_order' => 209,
        ]);

        $set->questions()->create([
            'question' => "Question 210\n\nWhich Amazon EC2 Reserved Instances term commitment will give users the MOST cost savings?",
            'options' => [
                '1 year',
                '2 years',
                '3 years',
                '5 years',
            ],
            'correct_answer' => '3 years',
            'explanation' => 'Amazon EC2 Reserved Instances are available with 1-year or 3-year terms. The 3-year term provides a greater discount and more cost savings than the 1-year term. AWS does not offer standard 2-year or 5-year Reserved Instance terms.',
            'sort_order' => 210,
        ]);

        $set->questions()->create([
            'question' => "Question 211\n\nA company wants an integrated development environment (IDE) to deploy a machine learning (ML) model.\n\nWhich AWS service will meet this requirement?",
            'options' => [
                'AWS CodeBuild',
                'Amazon CodeGuru',
                'Amazon Athena',
                'Amazon SageMaker Studio',
            ],
            'correct_answer' => 'Amazon SageMaker Studio',
            'explanation' => 'Amazon SageMaker Studio is an integrated development environment (IDE) designed for machine learning. It provides tools to build, train, test, and deploy ML models within a unified environment.',
            'sort_order' => 211,
        ]);

        $set->questions()->create([
            'question' => "Question 212\n\nA company needs to put its AWS resources into groups and then determine the cost for each group.\n\nWhich AWS service or feature can the company use to group the resources?",
            'options' => [
                'Cost allocation tags',
                'AWS Budgets',
                'AWS Billing Conductor',
                'AWS Identity and Access Management (IAM)',
            ],
            'correct_answer' => 'Cost allocation tags',
            'explanation' => 'Cost allocation tags are labels that a company can assign to AWS resources to categorize and track costs. The company can group resources by department, project, or environment and then analyze the costs associated with each group.',
            'sort_order' => 212,
        ]);

        $set->questions()->create([
            'question' => "Question 213\n\nA company wants to register a new domain name for the upcoming launch of a web application.\n\nWhich AWS service can the company use to register a new domain name?",
            'options' => [
                'Amazon Route 53',
                'Amazon CloudFront',
                'AWS Transit Gateway',
                'Amazon API Gateway',
            ],
            'correct_answer' => 'Amazon Route 53',
            'explanation' => 'Amazon Route 53 is a scalable and highly available Domain Name System (DNS) service that also provides domain registration. The company can use Route 53 to register and manage a new domain name for its web application.',
            'sort_order' => 213,
        ]);

        $set->questions()->create([
            'question' => "Question 214\n\nIn which ways does the AWS Cloud offer lower total cost of ownership (TCO) of computing resources than on-premises data centers? (Choose two.)",
            'options' => [
                'AWS replaces upfront capital expenditures with pay-as-you-go costs.',
                'AWS is designed for high availability, which eliminates user downtime.',
                'AWS eliminates the need for on-premises IT staff.',
                'AWS uses economies of scale to continually reduce prices.',
                'AWS offers a single pricing model for Amazon EC2 instances.',
            ],
            'correct_answer' => '[0,3]',
            'explanation' => 'AWS reduces total cost of ownership by replacing large upfront infrastructure investments with variable pay-as-you-go costs. AWS also benefits from massive economies of scale, which allow it to reduce service prices over time.',
            'sort_order' => 214,
        ]);

        $set->questions()->create([
            'question' => "Question 215\n\nA company needs to store data in an Amazon S3 bucket. The company will rarely access the data and can recreate the data if necessary.\n\nWhich S3 storage class will meet the requirements for this data MOST cost-effectively?",
            'options' => [
                'S3 Express One Zone',
                'S3 One Zone-Infrequent Access (S3 One Zone-IA)',
                'S3 Standard',
                'S3 Standard-Infrequent Access (S3 Standard-IA)',
            ],
            'correct_answer' => 'S3 One Zone-Infrequent Access (S3 One Zone-IA)',
            'explanation' => 'S3 One Zone-IA is a cost-effective storage class for data that is rarely accessed and can be recreated if necessary. It stores data in a single Availability Zone and costs less than S3 Standard-IA. It is suitable because the data does not require high availability across multiple Availability Zones.',
            'sort_order' => 215,
        ]);

        $set->questions()->create([
            'question' => "Question 216\n\nA company has migrated its workload to the AWS Cloud. The company wants to optimize existing Amazon EC2 resources.\n\nWhich AWS services or tools provide this functionality? (Choose two.)",
            'options' => [
                'AWS Elastic Beanstalk',
                'AWS Cost Explorer',
                'Amazon Detective',
                'AWS Compute Optimizer',
                'AWS Billing Conductor',
            ],
            'correct_answer' => '[1,3]',
            'explanation' => 'AWS Cost Explorer helps analyze EC2 costs and usage patterns and provides rightsizing recommendations to reduce unnecessary spending. AWS Compute Optimizer analyzes resource utilization and recommends optimal EC2 instance types and sizes to improve performance and cost efficiency.',
            'sort_order' => 216,
        ]);

        $set->questions()->create([
            'question' => "Question 217\n\nA company uses AWS Organizations. The company wants to apply security best practices from the AWS Well-Architected Framework to all of its AWS accounts.\n\nWhich AWS service will meet these requirements?",
            'options' => [
                'Amazon Macie',
                'Amazon Detective',
                'AWS Control Tower',
                'AWS Secrets Manager',
            ],
            'correct_answer' => 'AWS Control Tower',
            'explanation' => 'AWS Control Tower helps organizations implement security best practices and governance across multiple AWS accounts. It automates account setup and applies controls based on AWS best practices, helping maintain consistent security, compliance, and governance throughout the organization.',
            'sort_order' => 217,
        ]);

        $set->questions()->create([
            'question' => "Question 218\n\nA company wants its Amazon EC2 instances to be in different locations but share the same geographic area. The company also wants to use multiple power grids and independent networking connectivity for the EC2 instances.\n\nWhich solution meets these requirements?",
            'options' => [
                'Use EC2 instances in multiple edge locations in the same AWS Region.',
                'Use EC2 instances in multiple Availability Zones in the same AWS Region.',
                'Use EC2 instances in multiple Amazon Connect locations in the same AWS Region.',
                'Use EC2 instances in multiple AWS Artifact locations in the same AWS Region.',
            ],
            'correct_answer' => 'Use EC2 instances in multiple Availability Zones in the same AWS Region.',
            'explanation' => 'Availability Zones are separate physical locations within the same AWS Region. Each Availability Zone has independent power, cooling, and networking infrastructure. Deploying EC2 instances across multiple Availability Zones improves availability while keeping the instances within the same geographic area.',
            'sort_order' => 218,
        ]);

        $set->questions()->create([
            'question' => "Question 219\n\nA company wants to define a central data protection policy that works across AWS services for compute, storage, and database resources.\n\nWhich AWS service will meet this requirement?",
            'options' => [
                'AWS Batch',
                'AWS Elastic Disaster Recovery',
                'AWS Backup',
                'Amazon FSx',
            ],
            'correct_answer' => 'AWS Backup',
            'explanation' => 'AWS Backup is a centralized, fully managed service for protecting data across supported AWS compute, storage, and database services. It allows a company to create and manage backup policies, schedules, retention rules, and recovery points from one location.',
            'sort_order' => 219,
        ]);

        $set->questions()->create([
            'question' => "Question 220\n\nA food delivery company needs to block users in certain countries from accessing its website.\n\nWhich AWS service should the company use to meet this requirement?",
            'options' => [
                'AWS WAF',
                'AWS Control Tower',
                'Amazon Fraud Detector',
                'Amazon Pinpoint',
            ],
            'correct_answer' => 'AWS WAF',
            'explanation' => 'AWS WAF protects web applications by filtering and controlling incoming web requests. The company can create geographic match rules to identify users by country and block requests originating from specified countries.',
            'sort_order' => 220,
        ]);

        $set->questions()->create([
            'question' => "Question 221\n\nWhich AWS service provides a fully managed graph database for highly connected datasets?",
            'options' => [
                'Amazon DynamoDB',
                'Amazon RDS',
                'Amazon Neptune',
                'Amazon Aurora',
            ],
            'correct_answer' => 'Amazon Neptune',
            'explanation' => 'Amazon Neptune is a fully managed graph database service designed for highly connected datasets. It makes it easy to build and run applications involving relationships, such as social networks, recommendation engines, knowledge graphs, and fraud detection.',
            'sort_order' => 221,
        ]);

        $set->questions()->create([
            'question' => "Question 222\n\nWhich statement is an AWS Cloud best practice that focuses on the elasticity and agility of cloud computing?",
            'options' => [
                'Provision capacity based on past usage and theoretical peaks.',
                'Dynamically scale to meet usage demands.',
                'Build the application and infrastructure in a data center that grants physical access.',
                'Break apart the application into loosely coupled components.',
            ],
            'correct_answer' => 'Dynamically scale to meet usage demands.',
            'explanation' => 'Elasticity allows resources to scale up or down dynamically according to usage demands. This practice improves cost efficiency and resource utilization while providing the agility benefits of the AWS Cloud.',
            'sort_order' => 222,
        ]);

        $set->questions()->create([
            'question' => "Question 223\n\nWhich AWS service provides the ability to host a NoSQL database in the AWS Cloud?",
            'options' => [
                'Amazon Aurora',
                'Amazon DynamoDB',
                'Amazon RDS',
                'Amazon Redshift',
            ],
            'correct_answer' => 'Amazon DynamoDB',
            'explanation' => 'Amazon DynamoDB is a fully managed NoSQL database service. It provides fast and predictable performance, automatic scaling, and high availability without requiring users to manage database servers.',
            'sort_order' => 223,
        ]);

        $set->questions()->create([
            'question' => "Question 224\n\nA company\'s application uses Amazon EC2 instances, AWS Lambda functions, and AWS Fargate tasks that are deployed in multiple AWS Regions. The company needs to optimize cost across Regions by using a single purchasing option.\n\nWhich purchasing option will meet these requirements MOST cost-effectively?",
            'options' => [
                'Compute Savings Plans',
                'EC2 Instance Savings Plans',
                'On-Demand Instances',
                'Reserved Instances',
            ],
            'correct_answer' => 'Compute Savings Plans',
            'explanation' => 'Compute Savings Plans provide flexible cost savings across multiple AWS Regions and compute services, including Amazon EC2, AWS Lambda, and AWS Fargate. This makes them suitable for optimizing costs across different Regions and compute types through a single purchasing option.',
            'sort_order' => 224,
        ]);

        $set->questions()->create([
            'question' => "Question 225\n\nA company manages global applications that require static IP addresses.\n\nWhich AWS service would enable the company to improve the availability and performance of its applications?",
            'options' => [
                'Amazon CloudFront',
                'AWS Global Accelerator',
                'Amazon S3 Transfer Acceleration',
                'Amazon API Gateway',
            ],
            'correct_answer' => 'AWS Global Accelerator',
            'explanation' => 'AWS Global Accelerator provides static IP addresses that serve as fixed entry points to applications. It routes user traffic through the optimal AWS edge location to improve application availability, performance, and latency for global users.',
            'sort_order' => 225,
        ]);

        $set->questions()->create([
            'question' => "Question 226\n\nA company needs an AWS Support plan that provides programmatic case management through the AWS Support API.\n\nWhich support plan will meet this requirement MOST cost-effectively?",
            'options' => [
                'AWS Business Support',
                'AWS Basic Support',
                'AWS Developer Support',
                'AWS Enterprise Support',
            ],
            'correct_answer' => 'AWS Business Support',
            'explanation' => 'The AWS Business Support plan provides programmatic case management through the AWS Support API. It also offers 24/7 access to technical support and is more cost-effective than the Enterprise Support plan for this requirement.',
            'sort_order' => 226,
        ]);

        $set->questions()->create([
            'question' => "Question 227\n\nWhich option is the responsibility of AWS, according to the AWS shared responsibility model?",
            'options' => [
                'Management of guest operating systems',
                'Firewall configuration changes',
                'Hardware for compute resources',
                'Identity and access management',
            ],
            'correct_answer' => 'Hardware for compute resources',
            'explanation' => 'Under the AWS shared responsibility model, AWS is responsible for security of the cloud. This includes managing the underlying hardware, storage, networking, and physical facilities. Customers are responsible for guest operating systems, firewall configurations, identity and access management, and their data.',
            'sort_order' => 227,
        ]);

        $set->questions()->create([
            'question' => "Question 228\n\nA company needs to collect utilization metrics from Amazon EC2 instances and Amazon DynamoDB tables.\n\nWhich AWS service should the company use to meet these requirements?",
            'options' => [
                'AWS CloudTrail',
                'AWS Config',
                'Amazon CloudWatch',
                'AWS Trusted Advisor',
            ],
            'correct_answer' => 'Amazon CloudWatch',
            'explanation' => 'Amazon CloudWatch is a monitoring and observability service that collects metrics, logs, and event data from AWS resources, including Amazon EC2 instances and Amazon DynamoDB tables. It allows the company to track resource utilization, set alarms, and analyze performance trends.',
            'sort_order' => 228,
        ]);

        $set->questions()->create([
            'question' => "Question 229\n\nAn independent software vendor wants to deliver and share its custom Amazon Machine Images (AMIs) to prospective customers.\n\nWhich AWS service will meet these requirements?",
            'options' => [
                'AWS Marketplace',
                'AWS Data Exchange',
                'Amazon EC2',
                'AWS Organizations',
            ],
            'correct_answer' => 'AWS Marketplace',
            'explanation' => 'AWS Marketplace allows independent software vendors to list, distribute, and sell software products that are packaged as custom Amazon Machine Images (AMIs). Customers can find, purchase, and deploy these AMIs directly in their AWS accounts.',
            'sort_order' => 229,
        ]);

        $set->questions()->create([
            'question' => "Question 230\n\nA company needs an AWS-managed threat protection service for the perimeter of its application hosted on AWS.\n\nWhich AWS service will meet this requirement?",
            'options' => [
                'Amazon Detective',
                'Amazon Connect',
                'Amazon Inspector',
                'AWS Shield',
            ],
            'correct_answer' => 'AWS Shield',
            'explanation' => 'AWS Shield is a managed Distributed Denial of Service (DDoS) protection service that safeguards applications hosted on AWS. It provides threat protection at the application perimeter against external DDoS attacks.',
            'sort_order' => 230,
        ]);

        $set->questions()->create([
            'question' => "Question 231\n\nA company is planning to migrate a monolithic application to AWS. The company wants to modernize the application by splitting it into microservices. The company will deploy the microservices on AWS.\n\nWhich migration strategy should the company use?",
            'options' => [
                'Rehost',
                'Repurchase',
                'Replatform',
                'Refactor',
            ],
            'correct_answer' => 'Refactor',
            'explanation' => 'Refactoring involves redesigning and modifying an application to take advantage of cloud-native capabilities. Splitting a monolithic application into independently deployable microservices requires significant architectural changes, so the appropriate migration strategy is refactor.',
            'sort_order' => 231,
        ]);

        $set->questions()->create([
            'question' => "Question 232\n\nA company wants to migrate its server-based applications to the AWS Cloud. The company wants to determine the total cost of ownership for its compute resources that will be hosted on the AWS Cloud.\n\nWhich combination of AWS services or tools will meet these requirements? (Choose two.)",
            'options' => [
                'AWS Pricing Calculator',
                'Migration Evaluator',
                'AWS Support Center',
                'AWS Application Discovery Service',
                'AWS Database Migration Service (AWS DMS)',
            ],
            'correct_answer' => '[0,1]',
            'explanation' => 'AWS Pricing Calculator estimates the cost of AWS services based on the company\'s planned resource usage. Migration Evaluator analyzes the company\'s existing on-premises environment and builds a data-driven business case, including total cost of ownership comparisons for migration to AWS.',
            'sort_order' => 232,
        ]);

        $set->questions()->create([
            'question' => "Question 233\n\nWhich feature of Amazon S3 can restore accidentally deleted or overwritten objects?",
            'options' => [
                'S3 Access Points',
                'S3 Block Public Access',
                'S3 Versioning',
                'S3 Object Lock',
            ],
            'correct_answer' => 'S3 Versioning',
            'explanation' => 'S3 Versioning keeps multiple versions of an object in an Amazon S3 bucket. If an object is accidentally deleted or overwritten, a previous version can be restored. This helps protect data against accidental deletion, modification, or corruption.',
            'sort_order' => 233,
        ]);

        $set->questions()->create([
            'question' => "Question 234\n\nWhich AWS service or feature provides a firewall at the subnet level within a VPC?",
            'options' => [
                'Security group',
                'Network ACL',
                'Elastic network interface',
                'AWS WAF',
            ],
            'correct_answer' => 'Network ACL',
            'explanation' => 'A Network Access Control List (Network ACL) acts as a firewall at the subnet level within a VPC. It controls inbound and outbound traffic by using allow and deny rules and applies to all resources in the associated subnet.',
            'sort_order' => 234,
        ]);

        $set->questions()->create([
            'question' => "Question 235\n\nA cloud engineer needs to download AWS security and compliance documents for an upcoming audit.\n\nWhich AWS service can provide the documents?",
            'options' => [
                'AWS Trusted Advisor',
                'AWS Artifact',
                'AWS Well-Architected Tool',
                'AWS Systems Manager',
            ],
            'correct_answer' => 'AWS Artifact',
            'explanation' => 'AWS Artifact provides on-demand access to AWS security and compliance documents, including audit reports, certifications, and compliance agreements. These documents can be downloaded and used to prepare for audits and demonstrate compliance.',
            'sort_order' => 235,
        ]);

        $set->questions()->create([
            'question' => "Question 236\n\nWhich AWS service provides central management, governance, and sharing of AWS CloudFormation templates with member accounts of an organization in AWS Organizations?",
            'options' => [
                'AWS CodePipeline',
                'AWS Service Catalog',
                'Amazon Athena',
                'Amazon Elastic Container Registry (Amazon ECR)',
            ],
            'correct_answer' => 'AWS Service Catalog',
            'explanation' => 'AWS Service Catalog allows organizations to centrally manage, govern, and share approved AWS CloudFormation templates and other IT services with member accounts in AWS Organizations. This helps maintain consistent compliance and governance across multiple AWS accounts.',
            'sort_order' => 236,
        ]);

        $set->questions()->create([
            'question' => "Question 237\n\nA university receives a grant to conduct research by using AWS services. The research team needs to make sure the grant money lasts for the entire school year. The team has decided on a monthly allocation that adds up to the total grant amount.\n\nWhich AWS service or feature will notify the team if spending exceeds the planned amount?",
            'options' => [
                'AWS Budgets',
                'Cost Explorer',
                'Cost allocation tags',
                'Cost categories',
            ],
            'correct_answer' => 'AWS Budgets',
            'explanation' => 'AWS Budgets allows the team to create monthly spending limits and receive notifications when actual or forecasted costs exceed defined thresholds. This helps the team monitor spending and ensure the grant money lasts for the entire school year.',
            'sort_order' => 237,
        ]);

        $set->questions()->create([
            'question' => "Question 238\n\nWhich AWS service should a cloud engineer use to view API calls to AWS services?",
            'options' => [
                'Amazon CloudWatch',
                'AWS CloudTrail',
                'AWS Config',
                'AWS Artifact',
            ],
            'correct_answer' => 'AWS CloudTrail',
            'explanation' => 'AWS CloudTrail records API calls made to AWS services and provides a detailed history of actions performed in an AWS account. It records information such as the caller\'s identity, the time of the API call, the source IP address, and the request parameters. This information is useful for auditing, monitoring, and troubleshooting.',
            'sort_order' => 238,
        ]);

        $set->questions()->create([
            'question' => "Question 239\n\nA company needs to categorize and track AWS usage cost based on business categories.\n\nWhich AWS service or feature should the company use to meet these requirements?",
            'options' => [
                'Cost allocation tags',
                'AWS Organizations',
                'AWS Security Hub',
                'AWS Cost and Usage Report',
            ],
            'correct_answer' => 'Cost allocation tags',
            'explanation' => 'Cost allocation tags allow a company to label AWS resources according to business categories, such as departments, projects, applications, or environments. The company can use these tags to organize, track, and analyze AWS usage costs for each category.',
            'sort_order' => 239,
        ]);

        $set->questions()->create([
            'question' => "Question 240\n\nA company is building a business intelligence solution that uses Amazon Redshift. The company wants to use an AWS service to create interactive dashboards and not pay any upfront costs for it.\n\nWhich service should the company use?",
            'options' => [
                'Amazon CloudWatch',
                'AWS Health Dashboard',
                'AWS Service Catalog',
                'Amazon QuickSight',
            ],
            'correct_answer' => 'Amazon QuickSight',
            'explanation' => 'Amazon QuickSight is a scalable, serverless business intelligence (BI) service for creating interactive dashboards and analyzing data. It can connect to Amazon Redshift and uses pay-as-you-go pricing with no upfront costs.',
            'sort_order' => 240,
        ]);

        $set->questions()->create([
            'question' => "Question 241\n\nIn the AWS shared responsibility model, which tasks are the responsibility of AWS? (Choose two.)",
            'options' => [
                'Patch an Amazon EC2 instance operating system.',
                'Configure a security group.',
                'Monitor the health of an Availability Zone.',
                'Protect the infrastructure that runs Amazon EC2 instances.',
                'Manage access to the data in an Amazon S3 bucket.',
            ],
            'correct_answer' => '[2,3]',
            'explanation' => 'Under the AWS shared responsibility model, AWS is responsible for security of the cloud. This includes monitoring the health of Availability Zones and protecting the physical infrastructure, hardware, and networking that run Amazon EC2 instances. Customers are responsible for patching EC2 guest operating systems, configuring security groups, and managing access to data in Amazon S3.',
            'sort_order' => 241,
        ]);

        $set->questions()->create([
            'question' => "Question 242\n\nA company needs to schedule the rotation of database credentials in the AWS Cloud.\n\nWhich AWS service should the company use to perform this task?",
            'options' => [
                'AWS Identity and Access Management (IAM)',
                'AWS Managed Services (AMS)',
                'Amazon RDS',
                'AWS Secrets Manager',
            ],
            'correct_answer' => 'AWS Secrets Manager',
            'explanation' => 'AWS Secrets Manager securely stores, manages, and rotates credentials, including database credentials. It can automatically rotate credentials for supported services, such as Amazon RDS, according to a schedule defined by the company.',
            'sort_order' => 242,
        ]);

        $set->questions()->create([
            'question' => "Question 243\n\nA social media company wants to track relationships between users. The company wants to use a fully managed graph database.\n\nWhich AWS service will meet these requirements?",
            'options' => [
                'Amazon RDS',
                'Amazon Neptune',
                'Amazon Aurora',
                'Amazon Timestream',
            ],
            'correct_answer' => 'Amazon Neptune',
            'explanation' => 'Amazon Neptune is a fully managed graph database service that supports property graph and RDF graph models. It is designed for analyzing relationships between highly connected data, making it suitable for tracking relationships between social media users.',
            'sort_order' => 243,
        ]);

        $set->questions()->create([
            'question' => "Question 244\n\nWhat does Amazon CloudFront provide?",
            'options' => [
                'Automatic scaling for all resources to power an application from a single unified interface',
                'Secure delivery of data, videos, applications, and APIs to users globally with low latency',
                'Ability to directly manage traffic globally through a variety of routing types, including latency-based routing, geo DNS, geoproximity, and weighted round robin',
                'Automatic distribution of incoming application traffic across multiple targets, such as Amazon EC2 instances, containers, IP addresses, and AWS Lambda functions',
            ],
            'correct_answer' => 'Secure delivery of data, videos, applications, and APIs to users globally with low latency',
            'explanation' => 'Amazon CloudFront is a content delivery network (CDN) service. It securely delivers data, videos, applications, and APIs to users worldwide with low latency by caching content at AWS edge locations close to users.',
            'sort_order' => 244,
        ]);

        $set->questions()->create([
            'question' => "Question 245\n\nWhich of the following can the AWS Pricing Calculator do?",
            'options' => [
                'Project monthly AWS costs.',
                'Calculate historical AWS costs.',
                'Provide in-depth information about AWS pricing strategies.',
                'Provide users with access to their monthly bills.',
            ],
            'correct_answer' => 'Project monthly AWS costs.',
            'explanation' => 'AWS Pricing Calculator helps users estimate the expected monthly cost of AWS services before deploying resources. Users can configure services and usage details to create cost estimates and compare different architecture options.',
            'sort_order' => 245,
        ]);

        $set->questions()->create([
            'question' => "Question 246\n\nA company deployed an application in multiple AWS Regions around the world. The company wants to improve the application\'s performance and availability.\n\nWhich AWS service will meet these requirements?",
            'options' => [
                'AWS Global Accelerator',
                'Amazon DataZone',
                'AWS Cloud Map',
                'AWS Auto Scaling',
            ],
            'correct_answer' => 'AWS Global Accelerator',
            'explanation' => 'AWS Global Accelerator improves the performance and availability of global applications by routing user traffic through the AWS global network to the optimal healthy endpoint. It can automatically redirect traffic to another AWS Region if an endpoint becomes unhealthy.',
            'sort_order' => 246,
        ]);

        $set->questions()->create([
            'question' => "Question 247\n\nWhich AWS service can manage permissions for AWS resources by using policies?",
            'options' => [
                'Amazon Inspector',
                'Amazon Detective',
                'AWS Identity and Access Management (IAM)',
                'Amazon GuardDuty',
            ],
            'correct_answer' => 'AWS Identity and Access Management (IAM)',
            'explanation' => 'AWS Identity and Access Management (IAM) controls access to AWS resources by using policies. IAM policies define which users, groups, or roles can perform specific actions on particular AWS resources.',
            'sort_order' => 247,
        ]);

        $set->questions()->create([
            'question' => "Question 248\n\nA company is launching a mobile app in the AWS Cloud. The company wants the app\'s users to sign in through social media identity providers (IdPs).\n\nWhich AWS service will meet this requirement?",
            'options' => [
                'AWS Lambda',
                'Amazon Cognito',
                'AWS Secrets Manager',
                'Amazon CloudFront',
            ],
            'correct_answer' => 'Amazon Cognito',
            'explanation' => 'Amazon Cognito provides user authentication and identity management for web and mobile applications. It allows users to sign in through social identity providers such as Google, Facebook, and Apple.',
            'sort_order' => 248,
        ]);

        $set->questions()->create([
            'question' => "Question 249\n\nWhich AWS service supports a company\'s ability to treat infrastructure as code?",
            'options' => [
                'AWS CodeDeploy',
                'AWS Elastic Beanstalk',
                'Amazon API Gateway',
                'AWS CloudFormation',
            ],
            'correct_answer' => 'AWS CloudFormation',
            'explanation' => 'AWS CloudFormation allows a company to define and manage AWS infrastructure as code by using JSON or YAML templates. These templates can automatically and consistently create, update, and delete AWS resources.',
            'sort_order' => 249,
        ]);

        $set->questions()->create([
            'question' => "Question 250\n\nA company is running a workload in the AWS Cloud.\n\nWhich AWS best practice ensures the MOST cost-effective architecture for the workload?",
            'options' => [
                'Loose coupling',
                'Rightsizing',
                'Caching',
                'Redundancy',
            ],
            'correct_answer' => 'Rightsizing',
            'explanation' => 'Rightsizing involves selecting AWS resources with the appropriate type and size for a workload\'s actual requirements. It helps eliminate over-provisioned or underused resources, reducing unnecessary costs while maintaining the required performance.',
            'sort_order' => 250,
        ]);


        $set->questions()->create([
            'question' => "Question 251\n\nA company is planning to migrate to the AWS Cloud. The company is conducting organizational transformation and wants to become more responsive to customer inquiries and feedback.\n\nWhich task should the company perform to meet these requirements, according to the AWS Cloud Adoption Framework (AWS CAF)? (Choose two.)",
            'options' => [
                'Realign teams to focus on products and value streams.',
                'Create new value propositions with new products and services.',
                'Use agile methods to rapidly iterate and evolve.',
                'Use a new data and analytics platform to create actionable insights.',
                'Migrate and modernize legacy infrastructure.',
            ],
            'correct_answer' => json_encode([
                'Realign teams to focus on products and value streams.',
                'Use agile methods to rapidly iterate and evolve.',
            ]),
            'explanation' => 'AWS CAF recommends aligning teams around products and value streams to improve customer focus. Agile methods help teams respond quickly to customer feedback through continuous improvement.',
            'sort_order' => 251,
        ]);


        $set->questions()->create([
            'question' => "Question 252\n\nA company needs access to checks and recommendations that help the company follow AWS best practices for cost optimization, security, fault tolerance, performance, and service quotas.\n\nWhich combination of an AWS service and AWS Support plan on the AWS account will meet these requirements?",
            'options' => [
                'AWS Trusted Advisor with AWS Developer Support',
                'AWS Health Dashboard with AWS Enterprise Support',
                'AWS Trusted Advisor with AWS Business Support',
                'AWS Health Dashboard with AWS Enterprise On-Ramp Support',
            ],
            'correct_answer' => 'AWS Trusted Advisor with AWS Business Support',
            'explanation' => 'AWS Trusted Advisor provides best practice checks for cost optimization, security, fault tolerance, performance, and service quotas. Full access to these checks requires the AWS Business Support plan.',
            'sort_order' => 252,
        ]);


        $set->questions()->create([
            'question' => "Question 253\n\nA company plans to migrate to the AWS Cloud. The company wants to gather information about its on-premises data center.\n\nWhich AWS service should the company use to meet these requirements?",
            'options' => [
                'AWS Application Discovery Service',
                'AWS DataSync',
                'AWS Storage Gateway',
                'AWS Database Migration Service (AWS DMS)',
            ],
            'correct_answer' => 'AWS Application Discovery Service',
            'explanation' => 'AWS Application Discovery Service collects information about on-premises servers and applications to help plan AWS migrations.',
            'sort_order' => 253,
        ]);


        $set->questions()->create([
            'question' => "Question 254\n\nWhich AWS service provides users with AWS issued reports, certifications, accreditations, and third-party attestations?",
            'options' => [
                'AWS Artifact',
                'AWS Trusted Advisor',
                'AWS Health Dashboard',
                'AWS Config',
            ],
            'correct_answer' => 'AWS Artifact',
            'explanation' => 'AWS Artifact provides on-demand access to AWS compliance reports, certifications, accreditations, and third-party audit documents.',
            'sort_order' => 254,
        ]);


        $set->questions()->create([
            'question' => "Question 255\n\nA company uses AWS and has a VPC that includes two public subnets. The company needs to allow and deny specific inbound and outbound traffic for each public subnet.\n\nWhich AWS service or tool can the company use to meet this requirement?",
            'options' => [
                'Network ACL',
                'AWS WAF',
                'VPC route table entry',
                'Security group',
            ],
            'correct_answer' => 'Network ACL',
            'explanation' => 'A Network ACL controls inbound and outbound traffic at the subnet level and supports both allow and deny rules.',
            'sort_order' => 255,
        ]);


        $set->questions()->create([
            'question' => "Question 256\n\nA company wants to explore and analyze data in Amazon S3 by using a programming language.\n\nWhich AWS service will meet these requirements?",
            'options' => [
                'Amazon Kendra',
                'Amazon Athena',
                'Amazon Comprehend',
                'Amazon SageMaker',
            ],
            'correct_answer' => 'Amazon Athena',
            'explanation' => 'Amazon Athena lets you analyze data stored in Amazon S3 using standard SQL without managing servers.',
            'sort_order' => 256,
        ]);


        $set->questions()->create([
            'question' => "Question 257\n\nA company wants to monitor and block malicious HTTP and HTTPS requests that its Amazon CloudFront distributions receive.\n\nWhich AWS service should the company use to meet these requirements?",
            'options' => [
                'Amazon GuardDuty',
                'Amazon Inspector',
                'AWS WAF',
                'Amazon Detective',
            ],
            'correct_answer' => 'AWS WAF',
            'explanation' => 'AWS WAF protects CloudFront by monitoring and filtering HTTP/HTTPS requests using customizable web ACL rules.',
            'sort_order' => 257,
        ]);


        $set->questions()->create([
            'question' => "Question 258\n\nA company needs to use AWS technology to deploy a static website.\n\nWhich solution meets this requirement with the LEAST amount of operational overhead?",
            'options' => [
                'Deploy the website on Amazon EC2.',
                'Host the website on AWS Elastic Beanstalk.',
                'Deploy the website with Amazon Lightsail.',
                'Host the website on Amazon S3.',
            ],
            'correct_answer' => 'Host the website on Amazon S3.',
            'explanation' => 'Amazon S3 can host static websites without managing servers, making it the lowest operational overhead solution.',
            'sort_order' => 258,
        ]);


        $set->questions()->create([
            'question' => "Question 259\n\nWhich AWS service is always available free of charge to users?",
            'options' => [
                'Amazon Athena',
                'AWS Identity and Access Management (IAM)',
                'AWS Secrets Manager',
                'Amazon ElastiCache',
            ],
            'correct_answer' => 'AWS Identity and Access Management (IAM)',
            'explanation' => 'AWS Identity and Access Management (IAM) is available at no additional charge. You pay only for the AWS resources that IAM users access.',
            'sort_order' => 259,
        ]);


        $set->questions()->create([
            'question' => "Question 260\n\nWhich AWS Cloud Adoption Framework (AWS CAF) capabilities are in the business perspective? (Choose two.)",
            'options' => [
                'Data engineering',
                'Risk management',
                'Cloud fluency',
                'Strategic partnership',
                'Data monetization',
            ],
            'correct_answer' => json_encode([
                'Risk management',
                'Strategic partnership',
            ]),
            'explanation' => 'Risk management helps identify and manage business risks during cloud adoption. Strategic partnership aligns cloud initiatives with business goals through key partnerships.',
            'sort_order' => 260,
        ]);


        $set->questions()->create([
            'question' => "Question 261\n\nA company is preparing for an audit and wants documentation that AWS complies with the Payment Card Industry Data Security Standard (PCI DSS).\n\nWhere can the company find this documentation?",
            'options' => [
                'AWS Artifact',
                'AWS Organizations',
                'AWS Trusted Advisor',
                'AWS Support Center',
            ],
            'correct_answer' => 'AWS Artifact',
            'explanation' => 'AWS Artifact provides access to compliance reports and certifications, including PCI DSS documentation.',
            'sort_order' => 261,
        ]);


        $set->questions()->create([
            'question' => "Question 262\n\nA company wants to log in securely to Linux Amazon EC2 instances.\n\nHow can the company accomplish this goal?",
            'options' => [
                'Use SSH keys.',
                'Use a VPN.',
                'Use end-to-end encryption.',
                'Use Amazon Route 53.',
            ],
            'correct_answer' => 'Use SSH keys.',
            'explanation' => 'SSH key pairs provide secure authentication for logging in to Linux Amazon EC2 instances.',
            'sort_order' => 262,
        ]);


        $set->questions()->create([
            'question' => "Question 263\n\nWhat is the total volume of data that can be stored in Amazon S3?",
            'options' => [
                '10 PB',
                '50 PB',
                '100 PB',
                'Virtually unlimited',
            ],
            'correct_answer' => 'Virtually unlimited',
            'explanation' => 'Amazon S3 provides virtually unlimited storage capacity, allowing users to store any amount of data.',
            'sort_order' => 263,
        ]);


        $set->questions()->create([
            'question' => "Question 264\n\nA company needs to host an application in a specific geographic area to comply with regulations.\n\nWhich feature of the AWS global infrastructure will help the company meet this requirement?",
            'options' => [
                'Scalability',
                'Global footprint',
                'Availability',
                'Performance',
            ],
            'correct_answer' => 'Global footprint',
            'explanation' => 'AWS\'s global footprint lets customers choose specific AWS Regions to meet data residency and regulatory requirements.',
            'sort_order' => 264,
        ]);


        $set->questions()->create([
            'question' => "Question 265\n\nWhich AWS service makes it easier to monitor and troubleshoot application logs and cloud resources?",
            'options' => [
                'Amazon EC2',
                'AWS Identity and Access Management (IAM)',
                'Amazon CloudWatch',
                'AWS CloudTrail',
            ],
            'correct_answer' => 'Amazon CloudWatch',
            'explanation' => 'Amazon CloudWatch monitors AWS resources and application logs to help troubleshoot performance and operational issues.',
            'sort_order' => 265,
        ]);


        $set->questions()->create([
            'question' => "Question 266\n\nA company needs an AWS design solution for a distributed system. The system's components need to be set up so that one system component cannot negatively impact another component.\n\nWhich AWS architectural best practice will meet this requirement?",
            'options' => [
                'Use request throttling',
                'Use a stateful service',
                'Implement automatic data backups',
                'Implement loose coupling',
            ],
            'correct_answer' => 'Implement loose coupling',
            'explanation' => 'Loose coupling keeps system components independent, so a failure in one component does not affect others.',
            'sort_order' => 266,
        ]);


        $set->questions()->create([
            'question' => "Question 267\n\nWhat is the MINIMUM AWS Support plan that is required to access Support Automation Workflows that are maintained by AWS Support?",
            'options' => [
                'AWS Enterprise Support',
                'AWS Enterprise On-Ramp Support',
                'AWS Business Support',
                'AWS Developer Support',
            ],
            'correct_answer' => 'AWS Business Support',
            'explanation' => 'AWS Business Support is the minimum support plan required to access AWS Support Automation Workflows (SAW).',
            'sort_order' => 267,
        ]);


        $set->questions()->create([
            'question' => "Question 268\n\nA company is learning about its responsibilities that are related to the management of Amazon EC2 instances.\n\nWhich tasks for EC2 instances are the company's responsibility, according to the AWS shared responsibility model? (Choose two.)",
            'options' => [
                'Install and patch the machine hypervisor.',
                'Patch the guest operating system.',
                'Encrypt data at rest on associated storage.',
                'Install the physical hardware and cabling.',
                'Provide physical security for the EC2 instances.',
            ],
            'correct_answer' => json_encode([
                'Patch the guest operating system.',
                'Encrypt data at rest on associated storage.',
            ]),
            'explanation' => 'Customers are responsible for patching the guest operating system on EC2 instances. Customers are also responsible for encrypting data stored on attached storage such as Amazon EBS.',
            'sort_order' => 268,
        ]);


        $set->questions()->create([
            'question' => "Question 269\n\nA company is moving its data warehouse to AWS. The infrastructure on AWS must support the storage of terabytes of data and must process complex analytic queries.\n\nWhich AWS service will meet these requirements?",
            'options' => [
                'Amazon Redshift',
                'Amazon DynamoDB',
                'Amazon S3',
                'Amazon Aurora',
            ],
            'correct_answer' => 'Amazon Redshift',
            'explanation' => 'Amazon Redshift is a fully managed data warehouse designed for large-scale data storage and fast analytic queries.',
            'sort_order' => 269,
        ]);


        $set->questions()->create([
            'question' => "Question 270\n\nA company is using Amazon EC2 instances to test an application. The company needs to run uninterrupted tests for 1 month.\n\nWhich EC2 instance purchasing option will meet these requirements MOST cost-effectively?",
            'options' => [
                'On-Demand Instances',
                'Spot Instances',
                'Reserved Instances',
                'Compute Savings Plan',
            ],
            'correct_answer' => 'On-Demand Instances',
            'explanation' => 'On-Demand Instances are best for short-term, uninterrupted workloads without long-term commitments.',
            'sort_order' => 270,
        ]);


        $set->questions()->create([
            'question' => "Question 271\n\nA company has developed a new in-house application. The company does not have a way to determine or predict the usage demand that the application will create.\n\nWhich AWS Cloud computing benefit is the company seeking?",
            'options' => [
                'Easy to use',
                'Cost-effective',
                'Secure',
                'Scalable and high performance',
            ],
            'correct_answer' => 'Scalable and high performance',
            'explanation' => 'AWS provides scalable resources that can automatically adjust to unpredictable application demand while maintaining high performance.',
            'sort_order' => 271,
        ]);


        $set->questions()->create([
            'question' => "Question 272\n\nWhich task is the responsibility of the customer, according to the AWS shared responsibility model?",
            'options' => [
                'Maintain the security of the hardware that runs Amazon EC2 instances.',
                'Patch the guest operating system of Amazon EC2 instances.',
                'Protect the security of the AWS global infrastructure.',
                'Patch Amazon RDS software.',
            ],
            'correct_answer' => 'Patch the guest operating system of Amazon EC2 instances.',
            'explanation' => 'Customers are responsible for patching and managing the guest operating system on Amazon EC2 instances.',
            'sort_order' => 272,
        ]);


        $set->questions()->create([
            'question' => "Question 273\n\nA company wants to update its online data processing application by implementing container-based services that run for 4 hours at a time. The company does not want to provision or manage server instances.\n\nWhich AWS service will meet these requirements?",
            'options' => [
                'AWS Lambda',
                'AWS Fargate',
                'Amazon EC2',
                'AWS Elastic Beanstalk',
            ],
            'correct_answer' => 'AWS Fargate',
            'explanation' => 'AWS Fargate runs containers without provisioning or managing servers and supports long-running container workloads.',
            'sort_order' => 273,
        ]);


        $set->questions()->create([
            'question' => "Question 274\n\nA company wants to run an application on Amazon EC2 instances. The application has short-term, irregular workloads that cannot be interrupted.\n\nWhich will be the MOST cost-effective pricing model for this workload?",
            'options' => [
                'On-Demand Instances',
                'Dedicated Instances',
                'Reserved Instances',
                'Savings Plans',
            ],
            'correct_answer' => 'On-Demand Instances',
            'explanation' => 'On-Demand Instances are ideal for short-term, unpredictable workloads that require uninterrupted operation.',
            'sort_order' => 274,
        ]);


        $set->questions()->create([
            'question' => "Question 275\n\nAccording to the AWS shared responsibility model, which of the following are AWS responsibilities? (Choose two.)",
            'options' => [
                'Network infrastructure and virtualization of infrastructure',
                'Security of application data',
                'Guest operating systems',
                'Physical security of hardware',
                'Credentials and policies',
            ],
            'correct_answer' => json_encode([
                'Network infrastructure and virtualization of infrastructure',
                'Physical security of hardware',
            ]),
            'explanation' => 'AWS is responsible for the network infrastructure and virtualization layer. AWS is also responsible for the physical security of the hardware in its data centers.',
            'sort_order' => 275,
        ]);


        $set->questions()->create([
            'question' => "Question 276\n\nWhich AWS services can a company use to deploy a database on AWS? (Choose two.)",
            'options' => [
                'Elastic Load Balancing (ELB)',
                'AWS CloudTrail',
                'Amazon RDS',
                'Amazon EC2',
                'Amazon Elastic File System (Amazon EFS)',
            ],
            'correct_answer' => json_encode([
                'Amazon RDS',
                'Amazon EC2',
            ]),
            'explanation' => 'Amazon RDS is a managed database service. Amazon EC2 can host a self-managed database.',
            'sort_order' => 276,
        ]);


        $set->questions()->create([
            'question' => "Question 277\n\nA company has moved all its infrastructure to the AWS Cloud. To plan ahead for each quarter, the finance team wants to track the cost and usage data of all resources from previous months. The finance team wants to automatically generate reports that contain the data.\n\nWhich AWS service or feature should the finance team use to meet these requirements?",
            'options' => [
                'Amazon Detective',
                'AWS Pricing Calculator',
                'AWS Budgets',
                'AWS Savings Plans',
            ],
            'correct_answer' => 'AWS Budgets',
            'explanation' => 'AWS Budgets tracks AWS costs and usage over time and can generate reports to help with financial planning.',
            'sort_order' => 277,
        ]);


        $set->questions()->create([
            'question' => "Question 278\n\nA company needs to establish a connection between two VPCs. The VPCs are located in two different AWS Regions. The company wants to use the existing infrastructure of the VPCs for this connection.\n\nWhich AWS service or feature can be used to establish this connection?",
            'options' => [
                'AWS Client VPN',
                'VPC peering',
                'AWS Direct Connect',
                'VPC endpoints',
            ],
            'correct_answer' => 'VPC peering',
            'explanation' => 'VPC peering connects two VPCs, including across AWS Regions, using private IP addresses without additional infrastructure.',
            'sort_order' => 278,
        ]);


        $set->questions()->create([
            'question' => "Question 279\n\nA company wants an AWS service that can automate software deployment in Amazon EC2 instances and on-premises instances.\n\nWhich AWS service will meet this requirement?",
            'options' => [
                'AWS CodeCommit',
                'AWS CodeBuild',
                'AWS CodeDeploy',
                'AWS CodePipeline',
            ],
            'correct_answer' => 'AWS CodeDeploy',
            'explanation' => 'AWS CodeDeploy automates application deployments to Amazon EC2 instances and on-premises servers.',
            'sort_order' => 279,
        ]);


        $set->questions()->create([
            'question' => "Question 280\n\nWhich of the following is a way to use Amazon EC2 Auto Scaling groups to scale capacity in the AWS Cloud?",
            'options' => [
                'Scale the number of EC2 instances in or out automatically, based on demand.',
                'Use serverless EC2 instances.',
                'Scale the size of EC2 instances up or down automatically, based on demand.',
                'Transfer unused CPU resources between EC2 instances.',
            ],
            'correct_answer' => 'Scale the number of EC2 instances in or out automatically, based on demand.',
            'explanation' => 'Amazon EC2 Auto Scaling automatically adds or removes EC2 instances based on application demand.',
            'sort_order' => 280,
        ]);


        $set->questions()->create([
            'question' => "Question 281\n\nWhich design principles should a company apply to AWS Cloud workloads to maximize sustainability and minimize environmental impact? (Choose two.)",
            'options' => [
                'Maximize utilization of Amazon EC2 instances.',
                'Minimize utilization of Amazon EC2 instances.',
                'Minimize usage of managed services.',
                'Force frequent application reinstalls by users.',
                'Reduce the need for users to reinstall applications.',
            ],
            'correct_answer' => json_encode([
                'Maximize utilization of Amazon EC2 instances.',
                'Reduce the need for users to reinstall applications.',
            ]),
            'explanation' => 'Maximize EC2 utilization to reduce idle resources and improve efficiency. Reduce application reinstalls to minimize unnecessary resource usage.',
            'sort_order' => 281,
        ]);


        $set->questions()->create([
            'question' => "Question 282\n\nA company wants to consolidate its call centers to improve the customer voice and chat experience with call center agents.\n\nWhich AWS service or tool will meet these requirements?",
            'options' => [
                'Amazon Simple Notification Service (Amazon SNS)',
                'AWS Support Center',
                'Amazon Cognito',
                'Amazon Connect',
            ],
            'correct_answer' => 'Amazon Connect',
            'explanation' => 'Amazon Connect is a cloud contact center service that provides voice and chat capabilities for customer service agents.',
            'sort_order' => 282,
        ]);


        $set->questions()->create([
            'question' => "Question 283\n\nWhich AWS service offers object storage?",
            'options' => [
                'Amazon RDS',
                'Amazon Elastic File System (Amazon EFS)',
                'Amazon S3',
                'Amazon DynamoDB',
            ],
            'correct_answer' => 'Amazon S3',
            'explanation' => 'Amazon S3 is AWS\'s object storage service for storing and retrieving any amount of data.',
            'sort_order' => 283,
        ]);


        $set->questions()->create([
            'question' => "Question 284\n\nA company's cloud environment includes Amazon EC2 instances and Application Load Balancers. The company wants to improve protections for its cloud resources against DDoS attacks. The company also wants to have real-time visibility into any DDoS attacks.\n\nWhich AWS service will meet these requirements?",
            'options' => [
                'AWS Shield Standard',
                'AWS Firewall Manager',
                'AWS Shield Advanced',
                'Amazon GuardDuty',
            ],
            'correct_answer' => 'AWS Shield Advanced',
            'explanation' => 'AWS Shield Advanced provides enhanced DDoS protection with real-time attack visibility and mitigation for AWS resources.',
            'sort_order' => 284,
        ]);


        $set->questions()->create([
            'question' => "Question 285\n\nWhich AWS Cloud Adoption Framework (AWS CAF) perspective helps a company achieve confidentiality and integrity of its data?",
            'options' => [
                'Business',
                'Security',
                'Governance',
                'Operations',
            ],
            'correct_answer' => 'Security',
            'explanation' => 'The Security perspective helps protect data confidentiality, integrity, and availability through security controls and best practices.',
            'sort_order' => 285,
        ]);


        $set->questions()->create([
            'question' => "Question 286\n\nA company needs the ability to acquire resources when the resources are needed. The company also needs the ability to release the resources when the resources are no longer needed.\n\nWhich AWS concept represents the company's goals?",
            'options' => [
                'Scalability',
                'Sustainability',
                'Elasticity',
                'Operational excellence',
            ],
            'correct_answer' => 'Elasticity',
            'explanation' => 'Elasticity automatically adds resources when demand increases and releases them when demand decreases.',
            'sort_order' => 286,
        ]);


        $set->questions()->create([
            'question' => "Question 287\n\nWhich AWS service or resource can distribute TCP and UDP traffic?",
            'options' => [
                'Amazon API Gateway',
                'Application Load Balancer',
                'Network Load Balancer',
                'Gateway Load Balancer',
            ],
            'correct_answer' => 'Network Load Balancer',
            'explanation' => 'Network Load Balancer (NLB) distributes both TCP and UDP traffic with high performance and low latency.',
            'sort_order' => 287,
        ]);


        $set->questions()->create([
            'question' => "Question 288\n\nA company needs to create an encrypted network connection between two offices in different countries. The connection must be over the public internet.\n\nWhich AWS service should the company use to meet these requirements?",
            'options' => [
                'AWS Direct Connect',
                'Amazon VPC Lattice',
                'AWS Site-to-Site VPN',
                'AWS Cloud WAN',
            ],
            'correct_answer' => 'AWS Site-to-Site VPN',
            'explanation' => 'AWS Site-to-Site VPN provides a secure, encrypted connection over the public internet between different locations.',
            'sort_order' => 288,
        ]);


        $set->questions()->create([
            'question' => "Question 289\n\nWhich AWS Well-Architected Framework concept represents a system's ability to remain functional when the system encounters operational problems?",
            'options' => [
                'Consistency',
                'Elasticity',
                'Durability',
                'Latency',
            ],
            'correct_answer' => 'Durability',
            'explanation' => 'Durability is the ability of a system to continue functioning and protect data even when operational problems occur.',
            'sort_order' => 289,
        ]);


        $set->questions()->create([
            'question' => "Question 290\n\nA company needs to deploy an application with high availability and fault tolerance.\n\nHow should the company deploy the application to meet these requirements?",
            'options' => [
                'In a single Availability Zone in an AWS Region',
                'Across multiple Availability Zones in an AWS Region',
                'Across multiple subnets in an Availability Zone',
                'Across multiple edge locations by using AWS Outposts',
            ],
            'correct_answer' => 'Across multiple Availability Zones in an AWS Region',
            'explanation' => 'Deploying across multiple Availability Zones provides high availability and fault tolerance by protecting against the failure of a single Availability Zone.',
            'sort_order' => 290,
        ]);


        $set->questions()->create([
            'question' => "Question 291\n\nA company has a goal to run and monitor systems to deliver business value while continually improving support processes and procedures.\n\nWhich pillar of the AWS Well-Architected Framework does this goal meet?",
            'options' => [
                'Reliability',
                'Security',
                'Operational excellence',
                'Performance efficiency',
            ],
            'correct_answer' => 'Operational excellence',
            'explanation' => 'The Operational Excellence pillar focuses on running and monitoring systems to deliver business value while continuously improving processes and procedures. It emphasizes automation, monitoring, incident response, and continuous improvement to increase operational efficiency and reliability.',
            'sort_order' => 291,
        ]);


        $set->questions()->create([
            'question' => "Question 292\n\nA company wants to perform sentiment analysis on customer service email messages that it receives. The company wants to identify whether the customer service engagement was positive or negative.\n\nWhich AWS service should the company use to perform this analysis?",
            'options' => [
                'Amazon Textract',
                'Amazon Translate',
                'Amazon Comprehend',
                'Amazon Rekognition',
            ],
            'correct_answer' => 'Amazon Comprehend',
            'explanation' => 'Amazon Comprehend is a natural language processing (NLP) service that uses machine learning to analyze text. It can perform sentiment analysis to determine whether the tone of a message is positive, negative, neutral, or mixed. This makes it ideal for analyzing customer service emails and other text-based content.',
            'sort_order' => 292,
        ]);


        $set->questions()->create([
            'question' => "Question 293\n\nWhich tasks are responsibilities of the customer, according to the AWS shared responsibility model? (Choose two.)",
            'options' => [
                'Secure the virtualization layer.',
                'Encrypt data and maintain data integrity.',
                'Patch the Amazon RDS operating system.',
                'Maintain identity and access management controls.',
                'Secure Availability Zones.',
            ],
            'correct_answer' => json_encode([
                'Encrypt data and maintain data integrity.',
                'Maintain identity and access management controls.',
            ]),
            'explanation' => 'Customers are responsible for security in the cloud, including encrypting data, maintaining data integrity, and managing identity and access management controls. AWS is responsible for the virtualization layer, Amazon RDS operating system patching, and the security of Availability Zones.',
            'sort_order' => 293,
        ]);


        $set->questions()->create([
            'question' => "Question 294\n\nWhich AWS service can a company use to manage encryption keys in the cloud?",
            'options' => [
                'AWS License Manager',
                'AWS Certificate Manager (ACM)',
                'AWS CloudHSM',
                'AWS Directory Service',
            ],
            'correct_answer' => 'AWS CloudHSM',
            'explanation' => 'AWS CloudHSM is a cloud-based Hardware Security Module (HSM) service that enables customers to generate, store, and manage encryption keys in dedicated HSMs under their own control. It is designed for applications that require strict key management and compliance. AWS License Manager manages software licenses, AWS Certificate Manager manages SSL/TLS certificates, and AWS Directory Service provides managed directory services. If AWS KMS appears as an option in similar exam questions, AWS KMS is often the correct choice.',
            'sort_order' => 294,
        ]);


        $set->questions()->create([
            'question' => "Question 295\n\nWhich AWS service continuously monitors AWS accounts and workloads for malicious or unauthorized actions?",
            'options' => [
                'Amazon CloudWatch',
                'Amazon GuardDuty',
                'AWS Shield',
                'AWS WAF',
            ],
            'correct_answer' => 'Amazon GuardDuty',
            'explanation' => 'Amazon GuardDuty is an intelligent threat detection service that continuously monitors AWS accounts, workloads, and data for malicious or unauthorized activity. It analyzes data sources such as AWS CloudTrail, VPC Flow Logs, and DNS logs to detect threats like compromised accounts, unusual behavior, cryptocurrency mining, and unauthorized access. CloudWatch monitors performance and logs, AWS Shield protects against DDoS attacks, and AWS WAF filters web requests.',
            'sort_order' => 295,
        ]);


        $set->questions()->create([
            'question' => "Question 296\n\nWhich Amazon Route 53 routing policy can a company use to route traffic to multiple resources in specified proportions?",
            'options' => [
                'Weighted routing policy',
                'Multivalue answer routing policy',
                'Failover routing policy',
                'Latency routing policy',
            ],
            'correct_answer' => 'Weighted routing policy',
            'explanation' => 'The Weighted routing policy in Amazon Route 53 routes traffic to multiple resources based on assigned weights. This is useful for load balancing, A/B testing, blue/green deployments, and gradually rolling out new application versions. Multivalue answer routing returns multiple healthy IP addresses, failover routing uses primary and secondary resources, and latency routing sends users to the Region with the lowest latency.',
            'sort_order' => 296,
        ]);


        $set->questions()->create([
            'question' => "Question 297\n\nWhich AWS Cloud design principle is a company using when the company implements AWS CloudTrail?",
            'options' => [
                'Activate traceability.',
                'Use serverless compute architectures.',
                'Perform operations as code.',
                'Go global in minutes.',
            ],
            'correct_answer' => 'Activate traceability.',
            'explanation' => 'AWS CloudTrail records and tracks API calls and user activity across AWS services. By capturing detailed logs of actions performed in an AWS account, CloudTrail enables auditing, monitoring, troubleshooting, and security investigations. This follows the AWS Well-Architected design principle of activate traceability.',
            'sort_order' => 297,
        ]);


        $set->questions()->create([
            'question' => "Question 299\n\nA company manages AWS accounts in an organization in AWS Organizations. The company needs to limit the access to selected AWS services for these member accounts.\n\nWhich AWS service or feature will meet this requirement?",
            'options' => [
                'AWS Identity and Access Management (IAM)',
                'Service control policies (SCPs)',
                'Organizational units (OUs)',
                'Tag policies',
            ],
            'correct_answer' => 'Service control policies (SCPs)',
            'explanation' => 'Service control policies (SCPs) set permission boundaries for AWS accounts in AWS Organizations. They can allow or deny access to specific AWS services across member accounts.',
            'sort_order' => 299,
        ]);


        $set->questions()->create([
            'question' => "Question 300\n\nA company wants to run CPU-intensive workload across multiple Amazon EC2 instances.\n\nWhich EC2 instance type should the company use to meet this requirement?",
            'options' => [
                'General purpose instances',
                'Compute optimized instances',
                'Memory optimized instances',
                'Storage optimized instances',
            ],
            'correct_answer' => 'Compute optimized instances',
            'explanation' => 'Compute optimized instances are designed for CPU-intensive workloads and provide high-performance processors.',
            'sort_order' => 300,
        ]);


        $set->questions()->create([
            'question' => "Question 301\n\nWhich AWS service or feature gives users the ability to connect VPCs and on-premises networks to a central hub?",
            'options' => [
                'Virtual private gateway',
                'AWS Transit Gateway',
                'Internet gateway',
                'Customer gateway',
            ],
            'correct_answer' => 'AWS Transit Gateway',
            'explanation' => 'AWS Transit Gateway acts as a central hub to connect multiple VPCs and on-premises networks.',
            'sort_order' => 301,
        ]);


        $set->questions()->create([
            'question' => "Question 302\n\nA company's application is running on Amazon EC2 instances. The company is planning a partial migration to a serverless architecture in the next year and wants to pay for resources up front.\n\nWhich AWS purchasing option will optimize the company's costs?",
            'options' => [
                'Convertible Reserved Instances',
                'Spot Instances',
                'EC2 Instance Savings Plans',
                'Compute Savings Plan',
            ],
            'correct_answer' => 'Compute Savings Plan',
            'explanation' => 'Compute Savings Plans provide discounts across EC2, Lambda, and Fargate, making them ideal for workloads migrating to serverless.',
            'sort_order' => 302,
        ]);


        $set->questions()->create([
            'question' => "Question 303\n\nWhich task is the responsibility of the customer, according to the AWS shared responsibility model?",
            'options' => [
                'Patch the Amazon DynamoDB operating system.',
                'Secure Amazon CloudFront edge locations by allowing physical access according to the principle of least privilege.',
                'Protect the hardware that runs AWS services.',
                'Use AWS Identity and Access Management (IAM) according to the principle of least privilege.',
            ],
            'correct_answer' => 'Use AWS Identity and Access Management (IAM) according to the principle of least privilege.',
            'explanation' => 'Customers are responsible for managing IAM users, roles, and permissions by following the principle of least privilege.',
            'sort_order' => 303,
        ]);


        $set->questions()->create([
            'question' => "Question 298\n\nWhich of the following is a customer responsibility according to the AWS shared responsibility model?",
            'options' => [
                'Apply security patches for Amazon S3 infrastructure devices.',
                'Provide physical security for AWS datacenters.',
                'Install operating system updates on Lambda@Edge.',
                'Implement multi-factor authentication (MFA) for IAM user accounts.',
            ],
            'correct_answer' => 'Implement multi-factor authentication (MFA) for IAM user accounts.',
            'explanation' => 'According to the AWS shared responsibility model, customers are responsible for security in the cloud. This includes managing IAM users, permissions, passwords, and enabling multi-factor authentication (MFA) to secure access to AWS resources. AWS is responsible for patching Amazon S3 infrastructure devices, providing physical security for AWS data centers, and managing the underlying operating systems for Lambda and Lambda@Edge.',
            'sort_order' => 298,
        ]);


        $set->questions()->create([
            'question' => "Question 304\n\nWhich capabilities are in the platform perspective of the AWS Cloud Adoption Framework (AWS CAF)? (Choose two.)",
            'options' => [
                'Data protection',
                'Data governance',
                'Data architecture',
                'Data engineering',
                'Data science',
            ],
            'correct_answer' => json_encode([
                'Data architecture',
                'Data engineering',
            ]),
            'explanation' => 'The AWS Cloud Adoption Framework (AWS CAF) Platform perspective includes Data architecture and Data engineering capabilities.',
            'sort_order' => 304,
        ]);


        $set->questions()->create([
            'question' => "Question 305\n\nWhich AWS Support plans provide access to an AWS technical account manager (TAM)? (Choose two.)",
            'options' => [
                'AWS Basic Support',
                'AWS Developer Support',
                'AWS Business Support',
                'AWS Enterprise On-Ramp Support',
                'AWS Enterprise Support',
            ],
            'correct_answer' => json_encode([
                'AWS Enterprise On-Ramp Support',
                'AWS Enterprise Support',
            ]),
            'explanation' => 'Only AWS Enterprise On-Ramp Support and AWS Enterprise Support provide access to a Technical Account Manager (TAM).',
            'sort_order' => 305,
        ]);


        $set->questions()->create([
            'question' => "Question 306\n\nA company needs to check for IAM access keys that have not been rotated recently.\n\nWhich AWS service should the company use to meet this requirement?",
            'options' => [
                'AWS WAF',
                'AWS Shield',
                'Amazon Cognito',
                'AWS Trusted Advisor',
            ],
            'correct_answer' => 'AWS Trusted Advisor',
            'explanation' => 'AWS Trusted Advisor checks IAM access keys and identifies keys that have not been rotated recently.',
            'sort_order' => 306,
        ]);


        $set->questions()->create([
            'question' => "Question 307\n\nWhich AWS service can create a private network connection from on premises to the AWS Cloud?",
            'options' => [
                'AWS Config',
                'Virtual Private Cloud (Amazon VPC)',
                'AWS Direct Connect',
                'Amazon Route 53',
            ],
            'correct_answer' => 'AWS Direct Connect',
            'explanation' => 'AWS Direct Connect provides a dedicated private network connection between on-premises and AWS.',
            'sort_order' => 307,
        ]);


        $set->questions()->create([
            'question' => "Question 308\n\nWhich benefits does a company receive with AWS Business Support? (Choose two.)",
            'options' => [
                'Dedicated AWS technical account manager (TAM)',
                'Response time of less than 15 minutes for business-critical cases',
                'Phone, web, and chat support 24 hours a day, 7 days a week',
                'Full set of AWS Trusted Advisor best practice checks',
                'Well-Architected reviews',
            ],
            'correct_answer' => json_encode([
                'Phone, web, and chat support 24 hours a day, 7 days a week',
                'Full set of AWS Trusted Advisor best practice checks',
            ]),
            'explanation' => 'AWS Business Support provides 24/7 phone, web, and chat support and access to the full set of AWS Trusted Advisor checks.',
            'sort_order' => 308,
        ]);


        $set->questions()->create([
            'question' => "Question 309\n\nA company wants to enhance security by launching a third-party ISP intrusion detection system from its AWS account.\n\nWhich AWS service or resource should the company use to meet this requirement?",
            'options' => [
                'AWS Security Hub',
                'AWS Marketplace',
                'AWS Quick Starts',
                'AWS Security Center',
            ],
            'correct_answer' => 'AWS Marketplace',
            'explanation' => 'AWS Marketplace provides third-party security solutions, including intrusion detection systems (IDS), that can be deployed on AWS.',
            'sort_order' => 309,
        ]);


        $set->questions()->create([
            'question' => "Question 310\n\nA company wants to use Amazon EC2 instances for a stable production workload that will run for 1 year.\n\nWhich instance purchasing option meets these requirements MOST cost-effectively?",
            'options' => [
                'Dedicated Hosts',
                'Reserved Instances',
                'On-Demand Instances',
                'Spot Instances',
            ],
            'correct_answer' => 'Reserved Instances',
            'explanation' => 'Reserved Instances provide significant cost savings for stable, long-term workloads with a 1-year commitment.',
            'sort_order' => 310,
        ]);


        $set->questions()->create([
            'question' => "Question 311\n\nWhat is the MOST secure way to store passwords on AWS?",
            'options' => [
                'Store passwords in an Amazon S3 bucket.',
                'Store passwords as AWS CloudFormation parameters.',
                'Store passwords in AWS Storage Gateway.',
                'Store passwords in AWS Secrets Manager.',
            ],
            'correct_answer' => 'Store passwords in AWS Secrets Manager.',
            'explanation' => 'AWS Secrets Manager securely stores, encrypts, and manages passwords and other secrets.',
            'sort_order' => 311,
        ]);


        $set->questions()->create([
            'question' => "Question 312\n\nWhich AWS Cloud Adoption Framework (AWS CAF) perspective includes the risk management capability?",
            'options' => [
                'Governance',
                'Business',
                'Operations',
                'People',
            ],
            'correct_answer' => 'Governance',
            'explanation' => 'The Governance perspective includes risk management to identify and reduce cloud adoption risks.',
            'sort_order' => 312,
        ]);


        $set->questions()->create([
            'question' => "Question 313\n\nA company wants to connect its supported AWS services and VPCs. The company does not want to expose its internal traffic to the public internet.\n\nWhich AWS service will meet these requirements?",
            'options' => [
                'Amazon Inspector',
                'AWS PrivateLink',
                'Amazon Connect',
                'AWS Internet Gateway',
            ],
            'correct_answer' => 'AWS PrivateLink',
            'explanation' => 'AWS PrivateLink securely connects VPCs and supported AWS services without using the public internet.',
            'sort_order' => 313,
        ]);


        $set->questions()->create([
            'question' => "Question 314\n\nA company is migrating to the AWS Cloud instead of running its infrastructure on premises.\n\nWhich of the following are advantages of this migration? (Choose two.)",
            'options' => [
                'Elimination of the need to perform security auditing',
                'Increased global reach and agility',
                'Ability to deploy globally in minutes',
                'Elimination of the cost of IT staff members',
                'Redundancy by default for all compute services',
            ],
            'correct_answer' => json_encode([
                'Increased global reach and agility',
                'Ability to deploy globally in minutes',
            ]),
            'explanation' => 'AWS provides increased global reach and agility, and lets companies deploy applications globally in minutes.',
            'sort_order' => 314,
        ]);


        $set->questions()->create([
            'question' => "Question 315\n\nWhich of the following are economic benefits of using the AWS Cloud? (Choose two.)",
            'options' => [
                'Consumption-based pricing',
                'Perpetual licenses',
                'Economies of scale',
                'AWS Enterprise Support at no additional cost',
                'Bring-your-own-hardware model',
            ],
            'correct_answer' => json_encode([
                'Consumption-based pricing',
                'Economies of scale',
            ]),
            'explanation' => 'AWS offers pay-as-you-go consumption-based pricing and benefits from economies of scale to reduce costs.',
            'sort_order' => 315,
        ]);


        $set->questions()->create([
            'question' => "Question 316\n\nA company needs to provide users with a list of company-generated products built on AWS services. The company also needs to control access to these products by provisioning a personalized portal for specific users.\n\nWhich AWS service will meet these requirements?",
            'options' => [
                'Amazon Lightsail',
                'AWS App Runner',
                'Amazon AppFlow',
                'AWS Service Catalog',
            ],
            'correct_answer' => 'AWS Service Catalog',
            'explanation' => 'AWS Service Catalog provides a personalized portal to manage and control access to approved products.',
            'sort_order' => 316,
        ]);


        $set->questions()->create([
            'question' => "Question 317\n\nA company wants to deploy a web application as a containerized application. The company wants to use a managed service that can automatically create container images from source code and deploy the containerized application.\n\nWhich AWS service will meet these requirements?",
            'options' => [
                'AWS Elastic Beanstalk',
                'Amazon Elastic Container Service (Amazon ECS)',
                'AWS App Runner',
                'Amazon EC2',
            ],
            'correct_answer' => 'AWS App Runner',
            'explanation' => 'AWS App Runner automatically builds container images from source code and deploys the application.',
            'sort_order' => 317,
        ]);


        $set->questions()->create([
            'question' => "Question 318\n\nA company is designing workloads in the AWS Cloud. The company wants the workloads to perform their intended function correctly and consistently throughout their lifecycle.\n\nWhich pillar of the AWS Well-Architected Framework does this goal represent?",
            'options' => [
                'Operational excellence',
                'Security',
                'Reliability',
                'Performance efficiency',
            ],
            'correct_answer' => 'Reliability',
            'explanation' => 'The Reliability pillar ensures workloads perform correctly and consistently throughout their lifecycle.',
            'sort_order' => 318,
        ]);


        $set->questions()->create([
            'question' => "Question 319\n\nA company needs to centrally manage workforce identity access and permissions across AWS accounts and applications. Which AWS service provides this functionality?",
            'options' => [
                'Amazon Cognito',
                'AWS Control Tower',
                'AWS IAM Identity Center',
                'AWS IAM Roles Anywhere',
            ],
            'correct_answer' => 'AWS IAM Identity Center',
            'explanation' => 'AWS IAM Identity Center centrally manages workforce identities and permissions across multiple AWS accounts and applications.',
            'sort_order' => 319,
        ]);


        $set->questions()->create([
            'question' => "Question 320\n\nWhich AWS service or feature can a company use to apply security rules to a subnet for Amazon EC2 instances?",
            'options' => [
                'AWS WAF',
                'AWS Shield',
                'Network ACLs',
                'Security groups',
            ],
            'correct_answer' => 'Network ACLs',
            'explanation' => 'Network ACLs apply security rules at the subnet level, controlling inbound and outbound traffic.',
            'sort_order' => 320,
        ]);


        $set->questions()->create([
            'question' => "Question 321\n\nA company's project team needs to simultaneously mount a file system on multiple Amazon EC2 Linux instances. The file system also will be shared across multiple Availability Zones.\n\nWhich AWS service will meet these requirements?",
            'options' => [
                'Amazon Elastic File System (Amazon EFS)',
                'Amazon S3',
                'Amazon Elastic Block Store (Amazon EBS)',
                'Amazon FSx for Windows File Server',
            ],
            'correct_answer' => 'Amazon Elastic File System (Amazon EFS)',
            'explanation' => 'Amazon EFS provides a shared file system that multiple EC2 Linux instances can mount across multiple Availability Zones.',
            'sort_order' => 321,
        ]);


        $set->questions()->create([
            'question' => "Question 322\n\nA company has enabled billing alerts in its AWS account. The company needs to receive a notification through Amazon Simple Notification Service (Amazon SNS) whenever its monthly bill exceeds a defined amount.\n\nWhich AWS service or tool should the company use to meet this requirement?",
            'options' => [
                'Amazon CloudWatch',
                'AWS Cost Explorer',
                'AWS Cost and Usage Report',
                'AWS Pricing Calculator',
            ],
            'correct_answer' => 'Amazon CloudWatch',
            'explanation' => 'Amazon CloudWatch billing alarms send Amazon SNS notifications when billing exceeds a defined threshold.',
            'sort_order' => 322,
        ]);


        $set->questions()->create([
            'question' => "Question 323\n\nWhich benefit of the AWS Cloud helps companies achieve lower usage costs because of the aggregate usage of all AWS users?",
            'options' => [
                'No need to guess capacity',
                'Ability to go global in minutes',
                'Economies of scale',
                'Increased speed and agility',
            ],
            'correct_answer' => 'Economies of scale',
            'explanation' => 'Economies of scale reduce costs by sharing AWS infrastructure across many customers.',
            'sort_order' => 323,
        ]);


        $set->questions()->create([
            'question' => "Question 324\n\nA company needs to build applications that deliver low latency to end-user devices that use a 5G mobile network.\n\nWhich AWS service will meet these requirements?",
            'options' => [
                'AWS Wavelength',
                'AWS Outposts',
                'AWS Client VPN',
                'AWS Global Accelerator',
            ],
            'correct_answer' => 'AWS Wavelength',
            'explanation' => 'AWS Wavelength delivers ultra-low-latency applications by extending AWS services to 5G networks.',
            'sort_order' => 324,
        ]);


        $set->questions()->create([
            'question' => "Question 325\n\nA company simulates workflows to review and validate that all processes are effective and that staff are familiar with the processes.\n\nWhich design principle of the AWS Well-Architected Framework is the company following with this practice?",
            'options' => [
                'Perform operations as code.',
                'Refine operation procedures frequently.',
                'Make frequent, small, reversible changes.',
                'Structure the company to support business outcomes.',
            ],
            'correct_answer' => 'Refine operation procedures frequently.',
            'explanation' => 'Regularly testing and reviewing workflows helps improve and validate operational procedures.',
            'sort_order' => 325,
        ]);


        $set->questions()->create([
            'question' => "Question 326\n\nA company is deploying a set of Amazon EC2 instances into a VPC. The company needs to create a list of IP addresses that try to connect to the EC2 instances.\n\nWhich AWS service or feature will provide this information?",
            'options' => [
                'AWS CloudTrail logs',
                'Amazon CloudWatch metrics',
                'AWS Config',
                'VPC Flow Logs',
            ],
            'correct_answer' => 'VPC Flow Logs',
            'explanation' => 'VPC Flow Logs record IP traffic to and from EC2 instances in a VPC.',
            'sort_order' => 326,
        ]);


        $set->questions()->create([
            'question' => "Question 327\n\nA company needs to purchase Amazon EC2 instances to support an application that will run continuously for more than 1 year.\n\nWhich EC2 instance purchasing option meets these requirements MOST cost-effectively?",
            'options' => [
                'Dedicated Instances',
                'Spot Instances',
                'Reserved Instances',
                'On-Demand Instances',
            ],
            'correct_answer' => 'Reserved Instances',
            'explanation' => 'Reserved Instances provide the lowest cost for long-term, continuous workloads.',
            'sort_order' => 327,
        ]);


        $set->questions()->create([
            'question' => "Question 328\n\nA company wants to migrate 70 TB of data from its on-premises data center to AWS. The data is a mix of structured and unstructured data. The company wants to use a one-time migration strategy that is secure and cost-effective.\n\nWhich AWS service will meet these requirements?",
            'options' => [
                'Amazon Elastic File System (Amazon EFS)',
                'AWS Storage Gateway',
                'AWS Snowball Edge',
                'AWS Database Migration Service (AWS DMS)',
            ],
            'correct_answer' => 'AWS Snowball Edge',
            'explanation' => 'AWS Snowball Edge securely transfers large amounts of data for one-time migrations.',
            'sort_order' => 328,
        ]);


        $set->questions()->create([
            'question' => "Question 329\n\nA company's IT administrator needs to configure the AWS CLI for programmatic access to AWS services for the company's employees.\n\nWhich combination of credential components must the IT administrator use to meet this requirement? (Choose two.)",
            'options' => [
                'A public key',
                'A secret access key',
                'An IAM role',
                'An access key ID',
                'A private key',
            ],
            'correct_answer' => json_encode([
                'A secret access key',
                'An access key ID',
            ]),
            'explanation' => 'AWS CLI uses an access key ID and secret access key for authentication.',
            'sort_order' => 329,
        ]);


        $set->questions()->create([
            'question' => "Question 330\n\nA company wants its AWS usage to be more sustainable. The company wants to track, measure, review, and forecast polluting emissions that result from its AWS applications.\n\nWhich AWS service or tool can the company use to meet these requirements?",
            'options' => [
                'AWS Health Dashboard',
                'AWS Customer Carbon Footprint Tool',
                'AWS Support Center',
                'Amazon QuickSight',
            ],
            'correct_answer' => 'AWS Customer Carbon Footprint Tool',
            'explanation' => 'AWS Customer Carbon Footprint Tool tracks and forecasts carbon emissions from AWS usage.',
            'sort_order' => 330,
        ]);


        $set->questions()->create([
            'question' => "Question 331\n\nWhich of the following actions are controlled with AWS Identity and Access Management (IAM)? (Choose two.)",
            'options' => [
                'Control access to AWS service APIs and to other specific resources.',
                'Provide intelligent threat detection and continuous monitoring.',
                'Protect the AWS environment using multi-factor authentication (MFA).',
                'Grant users access to AWS data centers.',
                'Provide firewall protection for applications from common web attacks.',
            ],
            'correct_answer' => json_encode([
                'Control access to AWS service APIs and to other specific resources.',
                'Protect the AWS environment using multi-factor authentication (MFA).',
            ]),
            'explanation' => 'AWS Identity and Access Management (IAM) manages access to AWS resources and supports multi-factor authentication (MFA) for stronger security. Threat detection, data center access, and web application firewall protection are handled by other AWS services.',
            'sort_order' => 331,
        ]);


        $set->questions()->create([
            'question' => "Question 332\n\nA company wants to deploy an application that stores data in a relational database. The company wants database tasks, such as automated backups and database snapshots, to be managed by AWS.\n\nWhich AWS service will meet these requirements?",
            'options' => [
                'Amazon DocumentDB',
                'Amazon RDS',
                'Amazon Elastic Block Store (Amazon EBS)',
                'Amazon S3',
            ],
            'correct_answer' => 'Amazon RDS',
            'explanation' => 'Amazon RDS is a managed relational database service that automatically handles backups, snapshots, and routine database management tasks.',
            'sort_order' => 332,
        ]);


        $set->questions()->create([
            'question' => "Question 333\n\nA company needs a graph database service that is scalable and highly available.\n\nWhich AWS service meets these requirements?",
            'options' => [
                'Amazon Aurora',
                'Amazon Redshift',
                'Amazon DynamoDB',
                'Amazon Neptune',
            ],
            'correct_answer' => 'Amazon Neptune',
            'explanation' => 'Amazon Neptune is a fully managed graph database service that is scalable, highly available, and optimized for graph data.',
            'sort_order' => 333,
        ]);


        $set->questions()->create([
            'question' => "Question 334\n\nWhich AWS services can a company use to transfer on-premises data to the AWS Cloud? (Choose two.)"
,
            'options' => [
                'AWS Snowcone',
                'AWS Transit Gateway',
                'AWS DataSync',
                'AWS Backup',
                'Amazon Connect',
            ],
            'correct_answer' => json_encode([
                'AWS Snowcone',
                'AWS DataSync',
            ]),
            'explanation' => 'AWS Snowcone and AWS DataSync are services designed to transfer data from on-premises environments to the AWS Cloud.',
            'sort_order' => 334,
        ]);


        $set->questions()->create([
            'question' => "Question 335\n\nA company wants to use a centralized AWS service to enforce compliance with the organizational business standards. The company wants to use an AWS service that can govern and control who can deploy, manage, and decommission AWS resources.\n\nWhich AWS service will meet these requirements?",
            'options' => [
                'Amazon CloudWatch',
                'AWS Service Catalog',
                'Amazon GuardDuty',
                'AWS Security Hub',
            ],
            'correct_answer' => 'AWS Service Catalog',
            'explanation' => 'AWS Service Catalog lets organizations centrally manage approved AWS resources and control who can deploy and manage them.',
            'sort_order' => 335,
        ]);


        $set->questions()->create([
            'question' => "Question 336\n\nA company has multiple AWS accounts. The company needs to receive a consolidated bill from AWS and must centrally manage security and compliance.\n\nWhich AWS service or feature should the company use to meet these requirements?",
            'options' => [
                'AWS Cost and Usage Report',
                'AWS Organizations',
                'AWS Config',
                'AWS Security Hub',
            ],
            'correct_answer' => 'AWS Organizations',
            'explanation' => 'AWS Organizations provides consolidated billing and centralized management of multiple AWS accounts, security, and policies.',
            'sort_order' => 336,
        ]);


        $set->questions()->create([
            'question' => "Question 337\n\nA company needs a portable solution to collect data and run computations.\n\nWhich AWS service provides the MOST compact solution to meet these requirements?",
            'options' => [
                'AWS Snowcone',
                'AWS Snowball Edge',
                'Amazon S3',
                'AWS Outposts',
            ],
            'correct_answer' => 'AWS Snowcone',
            'explanation' => 'AWS Snowcone is the smallest AWS Snow device for portable data collection and edge computing.',
            'sort_order' => 337,
        ]);


        $set->questions()->create([
            'question' => "Question 338\n\nWhich AWS service can a company use to build conversational chatbots for customer service?",
            'options' => [
                'Amazon Lex',
                'AWS Amplify',
                'Amazon Comprehend',
                'Amazon Polly',
            ],
            'correct_answer' => 'Amazon Lex',
            'explanation' => 'Amazon Lex builds conversational chatbots using voice and text with natural language understanding (NLU).',
            'sort_order' => 338,
        ]);


        $set->questions()->create([
            'question' => "Question 339\n\nWhich AWS service or tool inspects a user's AWS environment and makes recommendations for cost savings and system performance improvements?",
            'options' => [
                'Cost Explorer',
                'AWS Trusted Advisor',
                'Amazon Inspector',
                'AWS Budgets',
            ],
            'correct_answer' => 'AWS Trusted Advisor',
            'explanation' => 'AWS Trusted Advisor analyzes your AWS environment and provides recommendations for cost optimization, performance, security, and best practices.',
            'sort_order' => 339,
        ]);


        $set->questions()->create([
            'question' => "Question 340\n\nA company wants to migrate its on-premises application to the AWS Cloud. The company is legally obligated to retain certain data in its on-premises data center.\n\nWhich AWS service or feature will support this requirement?",
            'options' => [
                'AWS Wavelength',
                'AWS Local Zones',
                'VMware Cloud on AWS',
                'AWS Outposts',
            ],
            'correct_answer' => 'AWS Outposts',
            'explanation' => 'AWS Outposts extends AWS services to on-premises environments, allowing data to remain on-site while using AWS infrastructure.',
            'sort_order' => 340,
        ]);


        $set->questions()->create([
            'question' => "Question 341\n\nWhich design principle is included in the operational excellence pillar of the AWS Well-Architected Framework?",
            'options' => [
                'Create annotated documentation.',
                'Anticipate failure.',
                'Ensure performance efficiency.',
                'Optimize costs.',
            ],
            'correct_answer' => 'Create annotated documentation.',
            'explanation' => 'Creating clear and annotated documentation is an Operational Excellence design principle that helps improve operations and management.',
            'sort_order' => 341,
        ]);


        $set->questions()->create([
            'question' => "Question 342\n\nA developer who has no AWS Cloud experience wants to use AWS technology to build a web application.\n\nWhich AWS service should the developer use to start building the application?",
            'options' => [
                'Amazon SageMaker',
                'AWS Lambda',
                'Amazon Lightsail',
                'Amazon Elastic Container Service (Amazon ECS)',
            ],
            'correct_answer' => 'Amazon Lightsail',
            'explanation' => 'Amazon Lightsail is a simple, beginner-friendly service for quickly building and hosting web applications.',
            'sort_order' => 342,
        ]);


        $set->questions()->create([
            'question' => "Question 343\n\nA team of researchers is going to collect data at remote locations around the world. Many locations do not have internet connectivity. The team needs to capture the data in the field, and transfer it to the AWS Cloud later.\n\nWhich AWS service will support these requirements?",
            'options' => [
                'AWS Outposts',
                'AWS Transfer Family',
                'AWS Snow Family',
                'AWS Migration Hub',
            ],
            'correct_answer' => 'AWS Snow Family',
            'explanation' => 'AWS Snow Family enables offline data collection and later transfer to the AWS Cloud from remote locations.',
            'sort_order' => 343,
        ]);


        $set->questions()->create([
            'question' => "Question 344\n\nWhich AWS service or tool gives a company the ability to release application changes in an automated way?",
            'options' => [
                'Amazon AppFlow',
                'AWS CodeDeploy',
                'AWS PrivateLink',
                'Amazon EKS Distro',
            ],
            'correct_answer' => 'AWS CodeDeploy',
            'explanation' => 'AWS CodeDeploy automates application deployments, making software releases faster and more reliable.',
            'sort_order' => 344,
        ]);


        $set->questions()->create([
            'question' => "Question 345\n\nWhich AWS service can manage a telephony infrastructure with a cloud contact center?",
            'options' => [
                'AWS Direct Connect',
                'Amazon Connect',
                'AWS CloudFormation',
                'Amazon CloudWatch',
            ],
            'correct_answer' => 'Amazon Connect',
            'explanation' => 'Amazon Connect is a cloud contact center service that manages telephony, customer calls, and IVR.',
            'sort_order' => 345,
        ]);


        $set->questions()->create([
            'question' => "Question 346\n\nWhich AWS service or tool provides recommendations to help users get rightsized Amazon EC2 instances based on historical workload usage data?",
            'options' => [
                'AWS Pricing Calculator',
                'AWS Compute Optimizer',
                'AWS App Runner',
                'AWS Systems Manager',
            ],
            'correct_answer' => 'AWS Compute Optimizer',
            'explanation' => 'AWS Compute Optimizer analyzes historical workload data and recommends the right-sized EC2 instances to improve performance and reduce costs.',
            'sort_order' => 346,
        ]);


        $set->questions()->create([
            'question' => "Question 347\n\nWhich AWS services are serverless? (Choose two.)",
            'options' => [
                'AWS Fargate',
                'Amazon Managed Streaming for Apache Kafka',
                'Amazon EMR',
                'Amazon S3',
                'Amazon EC2',
            ],
            'correct_answer' => json_encode([
                'AWS Fargate',
                'Amazon S3',
            ]),
            'explanation' => 'AWS Fargate and Amazon S3 are serverless services, so you do not need to manage servers.',
            'sort_order' => 347,
        ]);


        $set->questions()->create([
            'question' => "Question 348\n\nWhich AWS service uses speech-to-text conversion to help users create meeting notes?",
            'options' => [
                'Amazon Polly',
                'Amazon Textract',
                'Amazon Rekognition',
                'Amazon Transcribe',
            ],
            'correct_answer' => 'Amazon Transcribe',
            'explanation' => 'Amazon Transcribe converts speech to text, making it easy to create meeting notes and transcripts.',
            'sort_order' => 348,
        ]);


        $set->questions()->create([
            'question' => "Question 349\n\nWhich AWS service or feature improves network performance by sending traffic through the AWS worldwide network infrastructure?",
            'options' => [
                'Route table',
                'AWS Transit Gateway',
                'AWS Global Accelerator',
                'Amazon VPC',
            ],
            'correct_answer' => 'AWS Global Accelerator',
            'explanation' => 'AWS Global Accelerator improves network performance by routing traffic through the AWS global network.',
            'sort_order' => 349,
        ]);


        $set->questions()->create([
            'question' => "Question 350\n\nA company has a website on AWS. The company wants to deliver the website to a worldwide audience and provide low-latency response times for global users.\n\nWhich AWS service will meet these requirements?",
            'options' => [
                'AWS CloudFormation',
                'Amazon CloudFront',
                'Amazon ElastiCache',
                'Amazon DynamoDB',
            ],
            'correct_answer' => 'Amazon CloudFront',
            'explanation' => 'Amazon CloudFront is a CDN that delivers content globally with low latency by using edge locations.',
            'sort_order' => 350,
        ]);


        $set->questions()->create([
            'question' => "Question 351\n\nA company is running a key-value NoSQL workload on Amazon EC2 instances. The company needs the workload to have scalability, failover protection, and backup capabilities.\n\nWhat is the MOST operationally efficient way to meet these requirements?",
            'options' => [
                'Add additional EC2 instances to the database cluster.',
                'Run an identical copy of the database in a second Availability Zone.',
                'Migrate the database to Amazon DynamoDB.',
                'Migrate the database to a relational database.',
            ],
            'correct_answer' => 'Migrate the database to Amazon DynamoDB.',
            'explanation' => 'Amazon DynamoDB is a fully managed NoSQL database with built-in scalability, high availability, and automatic backups.',
            'sort_order' => 351,
        ]);


        $set->questions()->create([
            'question' => "Question 352\n\nWhich actions represent best practices for using AWS IAM? (Choose two.)",
            'options' => [
                'Configure a strong password policy.',
                'Share the security credentials among users of AWS accounts who are in the same Region.',
                'Use access keys to log in to the AWS Management Console.',
                'Rotate access keys on a regular basis.',
                'Avoid using IAM roles to delegate permissions.',
            ],
            'correct_answer' => json_encode([
                'Configure a strong password policy.',
                'Rotate access keys on a regular basis.',
            ]),
            'explanation' => 'Using a strong password policy and regularly rotating access keys are AWS IAM security best practices.',
            'sort_order' => 352,
        ]);


        $set->questions()->create([
            'question' => "Question 353\n\nA company has a client that uses an Amazon RDS database. The client requests information about operating system-level upgrades on the AWS resources that host the RDS database. The company employs a third-party provider to monitor the RDS database.\n\nWho is responsible for upgrading the operating systems for Amazon RDS under the AWS shared responsibility model?",
            'options' => [
                'The client',
                'The company',
                'AWS',
                'The third-party provider',
            ],
            'correct_answer' => 'AWS',
            'explanation' => 'AWS manages the operating system and underlying infrastructure for Amazon RDS as part of the shared responsibility model.',
            'sort_order' => 353,
        ]);


        $set->questions()->create([
            'question' => "Question 354\n\nWhich AWS Support plan provides customers with annual consultative and architectural guidance?",
            'options' => [
                'AWS Developer Support',
                'AWS Business Support',
                'AWS Enterprise On-Ramp Support',
                'AWS Enterprise Support',
            ],
            'correct_answer' => 'AWS Enterprise Support',
            'explanation' => 'AWS Enterprise Support provides annual architectural guidance and access to a Technical Account Manager (TAM).',
            'sort_order' => 354,
        ]);


        $set->questions()->create([
            'question' => "Question 355\n\nA company uses Amazon EC2 instances in its AWS account for several workloads. The company needs to perform an analysis to understand the cost of each workload.\n\nWhat is the MOST operationally efficient way to meet this requirement?",
            'options' => [
                'Move the EC2 instances for each workload into separate accounts.',
                'Use a different EC2 instance family for each workload.',
                'Add cost allocation tags to each EC2 instance. Activate the tags.',
                'Update any workload applications to publish usage data to a cost allocation database.',
            ],
            'correct_answer' => 'Add cost allocation tags to each EC2 instance. Activate the tags.',
            'explanation' => 'Cost allocation tags let you track and analyze costs for each workload in AWS Cost Explorer and billing reports.',
            'sort_order' => 355,
        ]);


        $set->questions()->create([
            'question' => "Question 356\n\nWhich AWS team or offering helps users accelerate cloud adoption through paid engagements in any of several specialty practice areas?",
            'options' => [
                'AWS Enterprise Support',
                'AWS solutions architects',
                'AWS Professional Services',
                'AWS account managers',
            ],
            'correct_answer' => 'AWS Professional Services',
            'explanation' => 'AWS Professional Services provides paid expert guidance to help organizations accelerate cloud adoption and migration.',
            'sort_order' => 356,
        ]);


        $set->questions()->create([
            'question' => "Question 357\n\nA company uses Amazon WorkSpaces.\n\nWhich task is the responsibility of AWS, according to the AWS shared responsibility model?",
            'options' => [
                'Set up multi-factor authentication (MFA) for each WorkSpaces user account.',
                'Ensure the environmental safety and security of the AWS infrastructure that hosts WorkSpaces.',
                'Provide security for WorkSpaces user accounts through AWS Identity and Access Management (IAM).',
                'Configure AWS CloudTrail to log API calls and user activity.',
            ],
            'correct_answer' => 'Ensure the environmental safety and security of the AWS infrastructure that hosts WorkSpaces.',
            'explanation' => 'AWS is responsible for the physical security and infrastructure that hosts Amazon WorkSpaces.',
            'sort_order' => 357,
        ]);


        $set->questions()->create([
            'question' => "Question 358\n\nWhich AWS service or feature gives users the ability to access AWS resources from any location by using an encrypted connection?",
            'options' => [
                'Amazon CloudFront',
                'AWS Client VPN',
                'AWS Direct Connect',
                'AWS PrivateLink',
            ],
            'correct_answer' => 'AWS Client VPN',
            'explanation' => 'AWS Client VPN provides secure, encrypted remote access to AWS resources from any location.',
            'sort_order' => 358,
        ]);


        $set->questions()->create([
            'question' => "Question 359\n\nA company wants to visualize and manage AWS Cloud costs and usage for a specific period of time.\n\nWhich AWS service or feature will meet these requirements?",
            'options' => [
                'Cost Explorer',
                'Consolidated billing',
                'AWS Organizations',
                'AWS Budgets',
            ],
            'correct_answer' => 'Cost Explorer',
            'explanation' => 'Cost Explorer lets you visualize, analyze, and manage AWS costs and usage over a selected time period.',
            'sort_order' => 359,
        ]);


        $set->questions()->create([
            'question' => "Question 360\n\nA company needs to have the ability to set up infrastructure for new applications in minutes.\n\nWhich advantage of cloud computing will help the company meet this requirement?",
            'options' => [
                'Trade fixed expense for variable expense',
                'Go global in minutes',
                'Increase speed and agility',
                'Stop guessing capacity',
            ],
            'correct_answer' => 'Increase speed and agility',
            'explanation' => 'Cloud computing enables rapid infrastructure provisioning, allowing applications to be deployed in minutes.',
            'sort_order' => 360,
        ]);


        $set->questions()->create([
            'question' => "Question 361\n\nWhich AWS service or resource can a company use to deploy AWS WAF rules?",
            'options' => [
                'Amazon EC2',
                'Application Load Balancer',
                'AWS Trusted Advisor',
                'Network Load Balancer',
            ],
            'correct_answer' => 'Application Load Balancer',
            'explanation' => 'AWS WAF can be attached to an Application Load Balancer (ALB) to filter and protect web traffic.',
            'sort_order' => 361,
        ]);


        $set->questions()->create([
            'question' => "Question 362\n\nWhich component must be attached to a VPC to enable inbound internet access?",
            'options' => [
                'NAT gateway',
                'VPC endpoint',
                'VPN connection',
                'Internet gateway',
            ],
            'correct_answer' => 'Internet gateway',
            'explanation' => 'An Internet Gateway (IGW) must be attached to a VPC to allow inbound and outbound internet access.',
            'sort_order' => 362,
        ]);


        $set->questions()->create([
            'question' => "Question 363\n\nWhich AWS service is used to temporarily provide federated security credentials to access AWS resources?",
            'options' => [
                'Amazon GuardDuty',
                'AWS Simple Token Service (AWS STS)',
                'AWS Secrets Manager',
                'AWS Certificate Manager',
            ],
            'correct_answer' => 'AWS Simple Token Service (AWS STS)',
            'explanation' => 'AWS STS provides temporary security credentials for federated users to access AWS resources.',
            'sort_order' => 363,
        ]);


        $set->questions()->create([
            'question' => "Question 364\n\nA company is using an Amazon RDS database.\n\nWhich task is the responsibility of AWS, according to the AWS shared responsibility model?",
            'options' => [
                'Configure IAM users.',
                'Manage the database schemas.',
                'Patch the host operating system\'s software.',
                'Configure security groups for database connections.',
            ],
            'correct_answer' => 'Patch the host operating system\'s software.',
            'explanation' => 'AWS is responsible for patching and maintaining the host operating system for Amazon RDS.',
            'sort_order' => 364,
        ]);


        $set->questions()->create([
            'question' => "Question 365\n\nWhich AWS service should a user use to change an AWS account root user password?",
            'options' => [
                'AWS IAM Identity Center',
                'AWS Management Console',
                'AWS Secrets Manager',
                'AWS Security Hub',
            ],
            'correct_answer' => 'AWS Management Console',
            'explanation' => 'The AWS Management Console allows users to change the AWS account root user password.',
            'sort_order' => 365,
        ]);


        $set->questions()->create([
            'question' => "Question 366\n\nA company wants to migrate to the AWS Cloud. The company needs the ability to acquire resources when the resources are necessary. The company also needs the ability to release those resources when the resources are no longer necessary.\n\nWhich architecture concept of the AWS Cloud meets these requirements?",
            'options' => [
                'Elasticity',
                'Availability',
                'Reliability',
                'Durability',
            ],
            'correct_answer' => 'Elasticity',
            'explanation' => 'Elasticity allows AWS resources to scale up or down automatically based on demand.',
            'sort_order' => 366,
        ]);


        $set->questions()->create([
            'question' => "Question 367\n\nWhich of the following is a pillar of the AWS Well-Architected Framework?",
            'options' => [
                'Redundancy',
                'Operational excellence',
                'Availability',
                'Multi-Region',
            ],
            'correct_answer' => 'Operational excellence',
            'explanation' => 'Operational Excellence is one of the AWS Well-Architected Framework pillars and focuses on running and improving workloads efficiently.',
            'sort_order' => 367,
        ]);


        $set->questions()->create([
            'question' => "Question 368\n\nA company migrated to the AWS Cloud. Now the company pays for services on an as-needed basis.\n\nWhich advantage of cloud computing is the company benefiting from?",
            'options' => [
                'Stop spending money running and maintaining data centers',
                'Increase speed and agility',
                'Go global in minutes',
                'Trade fixed expense for variable expense',
            ],
            'correct_answer' => 'Trade fixed expense for variable expense',
            'explanation' => 'With AWS, customers pay only for the resources they use, replacing fixed upfront costs with variable, pay-as-you-go pricing.',
            'sort_order' => 368,
        ]);


        $set->questions()->create([
            'question' => "Question 369\n\nA company needs AWS to automate monitoring, patch management, and backup services on the company's behalf.\n\nWhich AWS service or framework provides this functionality?",
            'options' => [
                'AWS Cloud Adoption Framework (AWS CAF)',
                'AWS Managed Services (AMS)',
                'AWS Support',
                'AWS Well-Architected Framework',
            ],
            'correct_answer' => 'AWS Managed Services (AMS)',
            'explanation' => 'AWS Managed Services (AMS) automates monitoring, patching, backups, and other operational tasks for AWS environments.',
            'sort_order' => 369,
        ]);


        $set->questions()->create([
            'question' => "Question 370\n\nA company wants to develop an accessibility application that will convert text into audible speech.\n\nWhich AWS service will meet this requirement?",
            'options' => [
                'Amazon MQ',
                'Amazon Polly',
                'Amazon Neptune',
                'Amazon Timestream',
            ],
            'correct_answer' => 'Amazon Polly',
            'explanation' => 'Amazon Polly converts text into natural-sounding speech using text-to-speech (TTS).',
            'sort_order' => 370,
        ]);


        $set->questions()->create([
            'question' => "Question 371\n\nWhich design principles are included in the reliability pillar of the AWS Well-Architected Framework? (Choose two.)",
            'options' => [
                'Automatically recover from failure.',
                'Grant everyone access to increase AWS service quotas.',
                'Stop guessing capacity.',
                'Design applications to run in a single Availability Zone.',
                'Plan to increase AWS service quotas first in a secondary AWS Region.',
            ],
            'correct_answer' => json_encode([
                'Automatically recover from failure.',
                'Stop guessing capacity.',
            ]),
            'explanation' => 'The Reliability pillar includes automatically recovering from failures and stopping guessing capacity to build resilient systems.',
            'sort_order' => 371,
        ]);


        $set->questions()->create([
            'question' => "Question 372\n\nA company needs to perform an audit of recent AWS account activity. The audit will investigate who initiated an event and what actions were performed.\n\nWhich AWS service should the company use to meet these requirements?",
            'options' => [
                'AWS Config',
                'Amazon Rekognition',
                'AWS CloudTrail',
                'Amazon Simple Notification Service (Amazon SNS)',
            ],
            'correct_answer' => 'AWS CloudTrail',
            'explanation' => 'AWS CloudTrail records AWS API activity, including who performed an action, when it occurred, and what resources were affected, making it the standard service for auditing and compliance.',
            'sort_order' => 372,
        ]);


        $set->questions()->create([
            'question' => "Question 373\n\nWhich design principle aligns with the performance efficiency pillar of the AWS Well-Architected Framework?",
            'options' => [
                'Using serverless architectures',
                'Scaling horizontally',
                'Measuring the cost of workloads',
                'Using managed services',
            ],
            'correct_answer' => 'Scaling horizontally',
            'explanation' => 'Scaling horizontally is a key design principle of the Performance Efficiency pillar. It improves performance and availability by adding more resources instead of increasing the size of a single server.',
            'sort_order' => 373,
        ]);


        $set->questions()->create([
            'question' => "Question 374\n\nA company wants to run containers on AWS by using Amazon Elastic Container Service (Amazon ECS). The company does not want to manage the underlying infrastructure.\n\nWhich AWS service can the company use to meet these requirements?",
            'options' => [
                'Amazon S3',
                'Amazon EC2',
                'AWS Fargate',
                'Amazon Elastic Container Registry (Amazon ECR)',
            ],
            'correct_answer' => 'AWS Fargate',
            'explanation' => 'AWS Fargate is a serverless compute engine for containers that runs Amazon ECS and EKS workloads without managing EC2 instances or infrastructure, making it ideal for fully managed container deployments.',
            'sort_order' => 374,
        ]);


        $set->questions()->create([
            'question' => "Question 375\n\nA company wants a list of all users in its AWS account, the status of all of the users' access keys, and if multi-factor authentication (MFA) has been configured.\n\nWhich AWS service or feature will meet these requirements?",
            'options' => [
                'AWS Key Management Service (AWS KMS)',
                'IAM Access Analyzer',
                'IAM credential report',
                'Amazon CloudWatch',
            ],
            'correct_answer' => 'IAM credential report',
            'explanation' => 'The IAM credential report provides a complete list of IAM users, including the status of access keys, password usage, and MFA configuration, making it the standard tool for IAM security auditing.',
            'sort_order' => 375,
        ]);


        $set->questions()->create([
            'question' => "Question 376\n\nA company that is planning to migrate to the AWS Cloud is based in an isolated area that has limited internet connectivity. The company needs to perform local data processing on premises. The company needs a solution that can operate without a stable internet connection.\n\nWhich AWS service will meet these requirements?",
            'options' => [
                'Amazon S3',
                'AWS Snowball Edge',
                'AWS Storage Gateway',
                'AWS Backup',
            ],
            'correct_answer' => 'AWS Snowball Edge',
            'explanation' => 'AWS Snowball Edge provides local storage and compute capabilities that can operate in environments with limited or no internet connectivity. It enables on-premises data processing and later transfers the data securely to AWS when connectivity is available.',
            'sort_order' => 376,
        ]);


        $set->questions()->create([
            'question' => "Question 377\n\nWhich capabilities are in the operations perspective of the AWS Cloud Adoption Framework (AWS CAF)? (Choose two.)",
            'options' => [
                'Observability',
                'Portfolio management',
                'Incident response',
                'Data governance',
                'Configuration management',
            ],
            'correct_answer' => json_encode([
                'Observability',
                'Incident response',
            ]),
            'explanation' => 'The Operations perspective in AWS CAF includes capabilities such as Observability and Incident response to help monitor systems, detect issues, and respond to operational events effectively.',
            'sort_order' => 377,
        ]);


        $set->questions()->create([
            'question' => "Question 378\n\nWhich capabilities are in the people perspective of the AWS Cloud Adoption Framework (AWS CAF)? (Choose two.)",
            'options' => [
                'Configuration management',
                'Culture evolution',
                'Change acceleration',
                'Security assurance',
                'Innovation management',
            ],
            'correct_answer' => json_encode([
                'Culture evolution',
                'Change acceleration',
            ]),
            'explanation' => 'The People perspective in AWS CAF focuses on preparing employees for cloud adoption. Culture evolution promotes a cloud-first mindset, while Change acceleration helps organizations manage training and organizational change effectively.',
            'sort_order' => 378,
        ]);


        $set->questions()->create([
            'question' => "Question 379\n\nWhich AWS service or feature allows users to securely store encrypted credentials and retrieve these credentials when required?",
            'options' => [
                'AWS Encryption SDK',
                'AWS Security Hub',
                'AWS Secrets Manager',
                'AWS Artifact',
            ],
            'correct_answer' => 'AWS Secrets Manager',
            'explanation' => 'AWS Secrets Manager securely stores, encrypts, and manages sensitive information such as database credentials, API keys, and passwords. Applications can securely retrieve these secrets when needed, and the service also supports automatic secret rotation.',
            'sort_order' => 379,
        ]);


        $set->questions()->create([
            'question' => "Question 380\n\nA company wants to migrate an on-premises call center to the AWS Cloud.\n\nWhich AWS service will meet this requirement?",
            'options' => [
                'AWS Direct Connect',
                'Amazon Polly',
                'Amazon Connect',
                'Amazon Lex',
            ],
            'correct_answer' => 'Amazon Connect',
            'explanation' => 'Amazon Connect is a cloud-based contact center service that enables companies to build and manage customer call centers in AWS. It supports inbound and outbound calls, IVR, call routing, and integration with other AWS services, making it the best choice for migrating an on-premises call center to the cloud.',
            'sort_order' => 380,
        ]);


        $set->questions()->create([
            'question' => "Question 381\n\nA company wants to add a conversational chatbot to its website.\n\nWhich AWS service can the company use to meet this requirement?",
            'options' => [
                'Amazon Textract',
                'Amazon Lex',
                'AWS Glue',
                'Amazon Rekognition',
            ],
            'correct_answer' => 'Amazon Lex',
            'explanation' => 'Amazon Lex is a service for building conversational chatbots using natural language understanding (NLU) and speech recognition. It enables websites and applications to provide interactive customer conversations through text or voice.',
            'sort_order' => 381,
        ]);


        $set->questions()->create([
            'question' => "Question 382\n\nA company has services that run in the AWS Cloud and in an on-premises data center. The company wants to set up a dedicated, high-throughput connection between AWS and the data center.\n\nWhich AWS service will meet these requirements?",
            'options' => [
                'Amazon VPC',
                'AWS Direct Connect',
                'Amazon CloudFront',
                'Amazon API Gateway',
            ],
            'correct_answer' => 'AWS Direct Connect',
            'explanation' => 'AWS Direct Connect provides a dedicated, high-bandwidth private network connection between an on-premises data center and AWS. It bypasses the public internet, delivering lower latency, more consistent performance, and increased security, making it ideal for hybrid cloud environments.',
            'sort_order' => 382,
        ]);


        $set->questions()->create([
            'question' => "Question 383\n\nWhich AWS service tracks API calls and user activity?",
            'options' => [
                'AWS Organizations',
                'AWS Config',
                'Amazon CloudWatch',
                'AWS CloudTrail',
            ],
            'correct_answer' => 'AWS CloudTrail',
            'explanation' => 'AWS CloudTrail records API calls and user activity across an AWS account. It logs actions made through the AWS Management Console, AWS CLI, SDKs, and AWS services, providing an audit trail for security, compliance, and troubleshooting.',
            'sort_order' => 383,
        ]);


        $set->questions()->create([
            'question' => "Question 384\n\nA company runs MySQL database workloads on self-managed servers in an on-premises data center. The company wants to migrate the database workloads to an AWS managed service.\n\nWhich migration strategy should the company use?",
            'options' => [
                'Rehost',
                'Repurchase',
                'Refactor',
                'Replatform',
            ],
            'correct_answer' => 'Replatform',
            'explanation' => 'Replatform means moving an application or database to the cloud with minor optimizations while keeping its core architecture. Migrating a self-managed MySQL database to a managed service like Amazon RDS for MySQL is a classic example of replatforming, because AWS takes over tasks such as patching, backups, and maintenance.',
            'sort_order' => 384,
        ]);


        $set->questions()->create([
            'question' => "Question 385\n\nWhich AWS service or feature should a company use between two microservices to ensure that messages are sent and received in exact order?",
            'options' => [
                'Amazon Simple Email Service (Amazon SES)',
                'Amazon Simple Notification Service (Amazon SNS)',
                'Amazon S3 Event Notifications',
                'Amazon Simple Queue Service (Amazon SQS) FIFO queues',
            ],
            'correct_answer' => 'Amazon Simple Queue Service (Amazon SQS) FIFO queues',
            'explanation' => 'Amazon SQS FIFO (First-In-First-Out) queues guarantee that messages are delivered and processed in the exact order they are sent. They also provide exactly-once processing, preventing duplicate messages. This makes FIFO queues ideal for communication between microservices when message order is critical.',
            'sort_order' => 385,
        ]);


        $set->questions()->create([
            'question' => "Question 386\n\nWhich group shares responsibility with AWS for security and compliance of AWS accounts and resources?",
            'options' => [
                'Third-party vendors',
                'Customers',
                'Reseller partners',
                'Internet providers',
            ],
            'correct_answer' => 'Customers',
            'explanation' => 'According to the AWS Shared Responsibility Model, AWS is responsible for the security of the cloud, while customers are responsible for the security in the cloud, including IAM permissions, data protection, encryption, operating systems where applicable, network configurations, and compliance of their AWS resources.',
            'sort_order' => 386,
        ]);


        $set->questions()->create([
            'question' => "Question 387\n\nA company needs to collect and assess on-premises server and application inventory data before moving its infrastructure to AWS.\n\nWhich AWS service provides this functionality?",
            'options' => [
                'Amazon AppFlow',
                'AWS Migration Hub',
                'Amazon QuickSight',
                'AWS Step Functions',
            ],
            'correct_answer' => 'AWS Migration Hub',
            'explanation' => 'AWS Migration Hub provides a central place to discover, collect, and assess on-premises server and application inventory before migration. It helps organizations plan and track migrations by analyzing servers, applications, and dependencies, making migration to AWS more efficient.',
            'sort_order' => 387,
        ]);


        $set->questions()->create([
            'question' => "Question 388\n\nA company wants to deploy some of its resources in the AWS Cloud. To meet regulatory requirements, the data must remain local and on premises. There must be low latency between AWS and the company resources.\n\nWhich AWS service or feature can be used to meet these requirements?",
            'options' => [
                'AWS Local Zones',
                'Availability Zones',
                'AWS Outposts',
                'AWS Wavelength Zones',
            ],
            'correct_answer' => 'AWS Outposts',
            'explanation' => 'AWS Outposts extends AWS infrastructure and services to an on-premises data center, allowing data to remain local to meet regulatory requirements while providing low-latency connectivity to AWS. It delivers a consistent AWS experience using the same APIs, tools, and services as the AWS Cloud.',
            'sort_order' => 388,
        ]);


        $set->questions()->create([
            'question' => "Question 389\n\nWhich architecture design principle describes the need to isolate failures between dependent components in the AWS Cloud?",
            'options' => [
                'Use a monolithic design.',
                'Design for automation.',
                'Design for single points of failure.',
                'Loosely couple components.',
            ],
            'correct_answer' => 'Loosely couple components.',
            'explanation' => 'Loosely coupled components minimize dependencies between application components. If one component fails, the failure is isolated and does not affect the entire system. This design improves reliability, fault isolation, and scalability, making it a key AWS Well-Architected design principle.',
            'sort_order' => 389,
        ]);


        $set->questions()->create([
            'question' => "Question 390\n\nWhich guidelines are best practices for using AWS Identity and Access Management (IAM)? (Choose two.)",
            'options' => [
                'Share access keys.',
                'Create individual IAM users.',
                'Use inline policies instead of customer managed policies.',
                'Grant maximum privileges to IAM users.',
                'Use groups to assign permissions to IAM users.',
            ],
            'correct_answer' => json_encode([
                'Create individual IAM users.',
                'Use groups to assign permissions to IAM users.',
            ]),
            'explanation' => 'Creating individual IAM users improves security, auditing, and access management. Using groups to assign permissions simplifies permission management and follows AWS IAM best practices.',
            'sort_order' => 390,
        ]);


        $set->questions()->create([
            'question' => "Question 391\n\nA company needs to establish a dedicated network connection from on premises to AWS. The connection must provide consistent, low-latency network performance.\n\nWhich AWS service should the company use to meet this requirement?",
            'options' => [
                'AWS Direct Connect',
                'AWS Site-to-Site VPN',
                'AWS Directory Service',
                'AWS Transit Gateway',
            ],
            'correct_answer' => 'AWS Direct Connect',
            'explanation' => 'AWS Direct Connect provides a dedicated private network connection between an on-premises data center and AWS. It delivers consistent, low-latency, and high-bandwidth connectivity by bypassing the public internet, making it ideal for workloads that require reliable and predictable network performance.',
            'sort_order' => 391,
        ]);


        $set->questions()->create([
            'question' => "Question 392\n\nA company has many developers who need programmatic access to AWS services. The company must provide the access in compliance with AWS security best practices.\n\nWhich solution will meet these requirements?",
            'options' => [
                'Require multi-factor authentication (MFA) for the AWS account root user and all IAM users. Rotate access keys.',
                'Create a single shared IAM user account for all the developers.',
                'Use the AWS account root user for programmatic access. Rotate access keys.',
                'Create IAM permissions boundaries. Require multi-factor authentication (MFA) for the AWS account root user.',
            ],
            'correct_answer' => 'Require multi-factor authentication (MFA) for the AWS account root user and all IAM users. Rotate access keys.',
            'explanation' => 'AWS security best practices recommend enabling MFA for the root user and all IAM users to provide an additional layer of security. In addition, access keys should be rotated regularly to reduce the risk of compromised credentials. Each developer should use an individual IAM user or role with appropriate permissions rather than sharing accounts or using the root user.',
            'sort_order' => 392,
        ]);


        $set->questions()->create([
            'question' => "Question 393\n\nWhich AWS service can migrate Amazon EC2 instances from one AWS Region to another?",
            'options' => [
                'AWS Application Migration Service',
                'AWS Database Migration Service (AWS DMS)',
                'AWS DataSync',
                'AWS Migration Hub',
            ],
            'correct_answer' => 'AWS Application Migration Service',
            'explanation' => 'AWS Application Migration Service (AWS MGN) simplifies migrating Amazon EC2 instances and other physical or virtual servers to another AWS Region with minimal downtime. It continuously replicates source servers and launches them in the target Region, making it the recommended service for server and EC2 migrations.',
            'sort_order' => 393,
        ]);


        $set->questions()->create([
            'question' => "Question 394\n\nWhich AWS service or feature identifies whether an Amazon S3 bucket or an IAM role has been shared with an external entity?",
            'options' => [
                'AWS Service Catalog',
                'AWS Systems Manager',
                'AWS IAM Access Analyzer',
                'AWS Organizations',
            ],
            'correct_answer' => 'AWS IAM Access Analyzer',
            'explanation' => 'AWS IAM Access Analyzer analyzes resource-based policies to identify resources, such as Amazon S3 buckets and IAM roles, that are shared with external AWS accounts or the public. It helps detect unintended external access and improves security by identifying resources that can be accessed outside your AWS organization.',
            'sort_order' => 394,
        ]);


        $set->questions()->create([
            'question' => "Question 395\n\nA company with multiple accounts and teams wants to set up a new multi-account AWS environment.\n\nWhich AWS service supports this requirement?",
            'options' => [
                'AWS CloudFormation',
                'AWS Control Tower',
                'AWS Config',
                'Amazon Virtual Private Cloud (Amazon VPC)',
            ],
            'correct_answer' => 'AWS Control Tower',
            'explanation' => 'AWS Control Tower helps organizations quickly set up and govern a secure, multi-account AWS environment based on AWS best practices. It automates account creation, applies guardrails, integrates with AWS Organizations, and provides centralized governance, making it the recommended service for managing multiple AWS accounts and teams.',
            'sort_order' => 395,
        ]);


        $set->questions()->create([
            'question' => "Question 396\n\nA company wants a solution that will automatically adjust the number of Amazon EC2 instances that are being used based on the current load.\n\nWhich AWS offering will meet these requirements?",
            'options' => [
                'Dedicated Hosts',
                'Placement groups',
                'Auto Scaling groups',
                'Reserved Instances',
            ],
            'correct_answer' => 'Auto Scaling groups',
            'explanation' => 'Amazon EC2 Auto Scaling automatically adjusts the number of EC2 instances in an Auto Scaling group based on demand, such as CPU utilization or traffic. It helps maintain application availability while optimizing costs by scaling out during high load and scaling in when demand decreases.',
            'sort_order' => 396,
        ]);


        $set->questions()->create([
            'question' => "Question 397\n\nA company wants to provide one of its employees with access to Amazon RDS. The company also wants to limit the interaction to only the AWS CLI and AWS software development kits (SDKs).\n\nWhich combination of actions should the company take to meet these requirements while following the principles of least privilege? (Choose two.)",
            'options' => [
                'Create an IAM user and provide AWS Management Console access only.',
                'Create an IAM user and provide programmatic access only.',
                'Create an IAM role and provide AWS Management Console access only.',
                'Create an IAM policy with administrator access and attach it to the IAM user.',
                'Create an IAM policy with Amazon RDS access and attach it to the IAM user.',
            ],
            'correct_answer' => json_encode([
                'Create an IAM user and provide programmatic access only.',
                'Create an IAM policy with Amazon RDS access and attach it to the IAM user.',
            ]),
            'explanation' => 'Create an IAM user with programmatic access only so the employee can use only the AWS CLI and SDKs. Attach an IAM policy with Amazon RDS permissions to follow the principle of least privilege instead of granting administrator access.',
            'sort_order' => 397,
        ]);


        $set->questions()->create([
            'question' => "Question 398\n\nA company needs to set up user authentication for a new application. Users must be able to sign in directly with a username and password, or through a third-party provider.\n\nWhich AWS service should the company use to meet these requirements?",
            'options' => [
                'AWS IAM Identity Center',
                'AWS Signer',
                'Amazon Cognito',
                'AWS Directory Service',
            ],
            'correct_answer' => 'Amazon Cognito',
            'explanation' => 'Amazon Cognito provides user authentication and authorization for web and mobile applications. It supports username and password sign-in as well as federated sign-in through third-party identity providers such as Google, Facebook, Apple, Amazon, and SAML or OpenID Connect (OIDC) providers.',
            'sort_order' => 398,
        ]);


        $set->questions()->create([
            'question' => "Question 399\n\nWhich AWS service or tool does AWS Control Tower use to create resources?",
            'options' => [
                'AWS CloudFormation',
                'AWS Trusted Advisor',
                'AWS Directory Service',
                'AWS Cost Explorer',
            ],
            'correct_answer' => 'AWS CloudFormation',
            'explanation' => 'AWS Control Tower uses AWS CloudFormation to automatically create and configure AWS resources across multiple AWS accounts. CloudFormation templates define the infrastructure and settings that Control Tower deploys to establish and manage a well-architected multi-account AWS environment.',
            'sort_order' => 399,
        ]);


        $set->questions()->create([
            'question' => "Question 400\n\nWhich of the following are ways to improve security on AWS? (Choose two.)",
            'options' => [
                'Using AWS Artifact',
                'Granting the broadest permissions to all IAM roles',
                'Running application code with AWS Cloud',
                'Enabling multi-factor authentication (MFA) with Amazon Cognito',
                'Using AWS Trusted Advisor security checks',
            ],
            'correct_answer' => json_encode([
                'Enabling multi-factor authentication (MFA) with Amazon Cognito',
                'Using AWS Trusted Advisor security checks',
            ]),
            'explanation' => 'Enabling multi-factor authentication (MFA) adds an extra layer of security. AWS Trusted Advisor security checks help identify security risks and provide recommendations based on AWS best practices.',
            'sort_order' => 400,
        ]);
        $set->questions()->create([
            'question' => "Question 401\n\nA company needs to set up dedicated network connectivity between its on-premises data center and the AWS Cloud. The network cannot use the public internet.\n\nWhich AWS service or feature will meet these requirements?",
            'options' => [
                'AWS Transit Gateway',
                'AWS VPN',
                'Amazon CloudFront',
                'AWS Direct Connect',
            ],
            'correct_answer' => 'AWS Direct Connect',
            'explanation' => 'AWS Direct Connect provides a dedicated private connection between an on-premises data center and AWS without using the public internet. It offers more consistent performance and lower latency than internet-based connections.',
            'sort_order' => 401,
        ]);
        $set->questions()->create([
            'question' => "Question 402\n\nA company is deploying a web application on Amazon EC2 instances.\n\nWhich task is the responsibility of AWS, according to the AWS shared responsibility model?",
            'options' => [
                'Configure IAM permissions.',
                'Configure security groups.',
                "Manage the security of the EC2 instances' hardware.",
                "Manage the security of the EC2 instances' guest operating system.",
            ],
            'correct_answer' => "Manage the security of the EC2 instances' hardware.",
            'explanation' => 'AWS is responsible for the security of the cloud, including the physical hardware that runs EC2 instances. Customers are responsible for IAM, security groups, and the guest operating system.',
            'sort_order' => 402,
        ]);
        $set->questions()->create([
            'question' => "Question 403\n\nA company's gaming application has been gaining popularity. There has been high demand for the gaming application in countries where the company does not currently deploy the application.\n\nWhich advantage of the AWS Cloud can help the company to deploy the application to more countries around the world?",
            'options' => [
                'Benefit from massive economies of scale',
                'Increase speed and agility',
                'Trade fixed expense for variable expense',
                'Go global in minutes',
            ],
            'correct_answer' => 'Go global in minutes',
            'explanation' => 'AWS enables companies to quickly deploy applications in multiple Regions around the world, making it easy to serve customers in new countries with low latency.',
            'sort_order' => 403,
        ]);
        $set->questions()->create([
            'question' => "Question 404\n\nA company wants to provide low latency to its users around the world.\n\nWhich feature of the AWS Cloud meets this requirement?",
            'options' => [
                'Global infrastructure',
                'Pay-as-you-go pricing',
                'Managed services',
                'Economy of scale',
            ],
            'correct_answer' => 'Global infrastructure',
            'explanation' => 'AWS Global Infrastructure provides Regions and Edge Locations worldwide, allowing applications to be deployed closer to users for lower latency.',
            'sort_order' => 404,
        ]);
        $set->questions()->create([
            'question' => "Question 405\n\nA company plans to migrate its application from on premises to the AWS Cloud. The company needs to gather usage and configuration data for the application components.\n\nWhich AWS service will meet these requirements?",
            'options' => [
                'AWS Database Migration Service (AWS DMS)',
                'AWS Transfer Family',
                'AWS Application Discovery Service',
                'AWS Global Accelerator',
            ],
            'correct_answer' => 'AWS Application Discovery Service',
            'explanation' => 'AWS Application Discovery Service collects usage, configuration, and dependency data from on-premises applications to help plan AWS migrations.',
            'sort_order' => 405,
        ]);
        $set->questions()->create([
            'question' => "Question 406\n\nWhich AWS service uses edge locations to cache content?",
            'options' => [
                'Amazon Kinesis',
                'Amazon Simple Queue Service (Amazon SQS)',
                'Amazon CloudFront',
                'Amazon Route 53',
            ],
            'correct_answer' => 'Amazon CloudFront',
            'explanation' => 'Amazon CloudFront uses AWS Edge Locations to cache content closer to users, reducing latency and improving content delivery speed.',
            'sort_order' => 406,
        ]);
        $set->questions()->create([
            'question' => "Question 407\n\nA company needs to manage multiple AWS accounts as a single unit. The company must consolidate billing for all the accounts.\n\nWhich AWS service should the company use to meet these requirements?",
            'options' => [
                'AWS Organizations',
                'AWS Resource Access Manager (AWS RAM)',
                'AWS Identity and Access Management (IAM)',
                'AWS Control Tower',
            ],
            'correct_answer' => 'AWS Organizations',
            'explanation' => 'AWS Organizations lets you manage multiple AWS accounts as one organization and provides consolidated billing across all accounts.',
            'sort_order' => 407,
        ]);
        $set->questions()->create([
            'question' => "Question 408\n\nA company's compliance officer wants to review the AWS Service Organization Control (SOC) reports.\n\nWhich AWS service or feature should the compliance officer use to complete this task?",
            'options' => [
                'AWS Artifact',
                'AWS Concierge Support',
                'AWS Support',
                'AWS Trusted Advisor',
            ],
            'correct_answer' => 'AWS Artifact',
            'explanation' => 'AWS Artifact provides on-demand access to AWS compliance reports, including SOC reports and other security and compliance documents.',
            'sort_order' => 408,
        ]);
        $set->questions()->create([
            'question' => "Question 409\n\nA company has an application that produces unstructured data continuously. The company needs to store the data so that the data is durable and easy to query.\n\nWhich AWS service can the company use to meet these requirements?",
            'options' => [
                'Amazon RDS',
                'Amazon Aurora',
                'Amazon QuickSight',
                'Amazon DynamoDB',
            ],
            'correct_answer' => 'Amazon DynamoDB',
            'explanation' => 'Amazon DynamoDB is a fully managed NoSQL database that stores unstructured data with high durability and provides fast, easy queries.',
            'sort_order' => 409,
        ]);
        $set->questions()->create([
            'question' => "Question 410\n\nIn which situations should a company create an IAM user instead of an IAM role?",
            'options' => [
                'When an application that runs on Amazon EC2 instances requires access to other AWS services',
                'When the company creates AWS access credentials for individuals',
                'When the company creates an application that runs on a mobile phone that makes requests to AWS',
                'When the company needs to add users to IAM groups',
                'When users are authenticated in the corporate network and want to be able to use AWS without having to sign in a second time',
            ],
            'correct_answer' => 'When the company creates AWS access credentials for individuals',
            'explanation' => 'Create an IAM user for individual people who need long-term AWS credentials. Use IAM roles for applications, AWS services, or temporary access.',
            'sort_order' => 410,
        ]);

        $set->questions()->create([
            'question' => "Question 411\n\nA company needs a serverless data integration service to discover, prepare, and combine data for analytics.\n\nWhich AWS service will meet these requirements?",
            'options' => [
                'Amazon EMR',
                'Amazon Redshift',
                'AWS Glue',
                'AWS Step Functions',
            ],
            'correct_answer' => 'AWS Glue',
            'explanation' => 'AWS Glue is a serverless data integration service that discovers, prepares, and transforms data for analytics.',
            'sort_order' => 411,
        ]);

        $set->questions()->create([
            'question' => "Question 412\n\nWhich AWS service provides on-premises applications with low-latency access to data that is stored in the AWS Cloud?",
            'options' => [
                'Amazon CloudFront',
                'AWS Storage Gateway',
                'AWS Backup',
                'AWS DataSync',
            ],
            'correct_answer' => 'AWS Storage Gateway',
            'explanation' => 'AWS Storage Gateway provides on-premises applications with low-latency access to data stored in AWS by using local caching while integrating with cloud storage.',
            'sort_order' => 412,
        ]);
        $set->questions()->create([
            'question' => "Question 413\n\nWhich AWS service should a company use to organize, characterize, and search large numbers of images?",
            'options' => [
                'Amazon Transcribe',
                'Amazon Rekognition',
                'Amazon Aurora',
                'Amazon QuickSight',
            ],
            'correct_answer' => 'Amazon Rekognition',
            'explanation' => 'Amazon Rekognition uses machine learning to analyze, organize, label, and search large collections of images and videos.',
            'sort_order' => 413,
        ]);
        $set->questions()->create([
            'question' => "Question 414\n\nWhat is the recommended use case for Amazon EC2 On-Demand Instances?",
            'options' => [
                'A steady-state workload that requires a particular EC2 instance configuration for a long period of time',
                'A workload that can be interrupted for a project that requires the lowest possible cost',
                'An unpredictable workload that does not require a long-term commitment',
                'A workload that is expected to run for longer than 1 year',
            ],
            'correct_answer' => 'An unpredictable workload that does not require a long-term commitment',
            'explanation' => 'Amazon EC2 On-Demand Instances are ideal for unpredictable workloads because they require no long-term commitment and you pay only for the compute capacity you use.',
            'sort_order' => 414,
        ]);
        $set->questions()->create([
            'question' => "Question 415\n\nA user is moving a workload from a local data center to an architecture that is distributed between the local data center and the AWS Cloud.\n\nWhich type of migration is this?",
            'options' => [
                'On-premises to cloud native',
                'Hybrid to cloud native',
                'On-premises to hybrid',
                'Cloud native to hybrid',
            ],
            'correct_answer' => 'On-premises to hybrid',
            'explanation' => 'An on-premises to hybrid migration keeps workloads running in both the local data center and the AWS Cloud.',
            'sort_order' => 415,
        ]);
        $set->questions()->create([
            'question' => "Question 416\n\nA company plans to deploy its application globally. The company wants to cache content at edge locations and deliver the content to users with the lowest possible latency.\n\nWhich AWS service will meet these requirements?",
            'options' => [
                'AWS Global Accelerator',
                'AWS Outposts',
                'Amazon Route 53',
                'Amazon CloudFront',
            ],
            'correct_answer' => 'Amazon CloudFront',
            'explanation' => 'Amazon CloudFront caches content at AWS Edge Locations and delivers it to users with low latency worldwide.',
            'sort_order' => 416,
        ]);
        $set->questions()->create([
            'question' => "Question 417\n\nWhich of the following are AWS best practice recommendations for the use of AWS Identity and Access Management (IAM)? (Choose two.)",
            'options' => [
                'Use the AWS account root user for daily access.',
                'Use access keys and secret access keys on Amazon EC2.',
                'Rotate credentials on a regular basis.',
                'Create a shared set of access keys for system administrators.',
                'Configure multi-factor authentication (MFA).',
            ],
            'correct_answer' => json_encode([
                'Rotate credentials on a regular basis.',
                'Configure multi-factor authentication (MFA).',
            ]),
            'explanation' => 'Regularly rotate credentials and enable MFA to improve account security and follow IAM best practices.',
            'sort_order' => 417,
        ]);
        $set->questions()->create([
            'question' => "Question 418\n\nA company wants to automatically set up and govern a multi-account AWS environment.\n\nWhich AWS service provides this functionality?",
            'options' => [
                'AWS IAM Identity Center',
                'AWS Systems Manager',
                'AWS Config',
                'AWS Control Tower',
            ],
            'correct_answer' => 'AWS Control Tower',
            'explanation' => 'AWS Control Tower automates the setup and governance of a secure multi-account AWS environment using landing zones and guardrails.',
            'sort_order' => 418,
        ]);
        $set->questions()->create([
            'question' => "Question 419\n\nA company runs its production workload in the AWS Cloud. The company needs to choose one of the AWS Support Plans.\n\nWhich of the AWS Support Plans will meet these requirements at the LOWEST cost?",
            'options' => [
                'Developer',
                'Enterprise On-Ramp',
                'Enterprise',
                'Business',
            ],
            'correct_answer' => 'Business',
            'explanation' => 'Business Support is the lowest-cost AWS Support plan recommended for production workloads. It provides 24/7 technical support and faster response times.',
            'sort_order' => 419,
        ]);
        $set->questions()->create([
            'question' => "Question 420\n\nWhich AWS Cloud Adoption Framework (AWS CAF) perspective focuses on real-time insights and answers questions about strategy?",
            'options' => [
                'Operations',
                'People',
                'Business',
                'Platform',
            ],
            'correct_answer' => 'Business',
            'explanation' => 'The Business perspective focuses on business outcomes, strategy, and real-time insights to help organizations achieve their business goals.',
            'sort_order' => 420,
        ]);
        $set->questions()->create([
            'question' => "Question 421\n\nA company needs to identify personally identifiable information (PII), such as credit card numbers, from data that is stored in Amazon S3.\n\nWhich AWS service should the company use to meet this requirement?",
            'options' => [
                'Amazon Inspector',
                'AWS Shield',
                'Amazon GuardDuty',
                'Amazon Macie',
            ],
            'correct_answer' => 'Amazon Macie',
            'explanation' => 'Amazon Macie uses machine learning to discover and identify sensitive data, including PII, in Amazon S3 buckets.',
            'sort_order' => 421,
        ]);
        $set->questions()->create([
            'question' => "Question 422\n\nA company needs a solution that provides recommended steps for migration to the AWS Cloud.\n\nWhich AWS service or tool will meet this requirement?",
            'options' => [
                'AWS CloudFormation',
                'AWS Application Discovery Service',
                'AWS Cloud Readiness Assessment',
                'Amazon CloudWatch',
            ],
            'correct_answer' => 'AWS Cloud Readiness Assessment',
            'explanation' => 'AWS Cloud Readiness Assessment evaluates an organization\'s readiness for cloud migration and provides recommended migration steps and best practices.',
            'sort_order' => 422,
        ]);
        $set->questions()->create([
            'question' => "Question 423\n\nA company wants to build an application that uses AWS Lambda to run Python code.\n\nUnder the AWS shared responsibility model, which tasks will be the company's responsibility? (Choose two.)",
            'options' => [
                'Management of the underlying infrastructure.',
                'Management of the operating system.',
                'Writing the business logic code.',
                'Installation of the computer language runtime.',
                'Providing AWS Identity and Access Management (IAM) access to the Lambda service.',
            ],
            'correct_answer' => json_encode([
                'Writing the business logic code.',
                'Providing AWS Identity and Access Management (IAM) access to the Lambda service.',
            ]),
            'explanation' => 'With AWS Lambda, customers are responsible for writing the application code and configuring IAM permissions. AWS manages the infrastructure, operating system, and runtime.',
            'sort_order' => 423,
        ]);
        $set->questions()->create([
            'question' => "Question 424\n\nWhich part of the AWS Global Infrastructure does Amazon CloudFront use to cache copies of content for rapid delivery to global users?",
            'options' => [
                'Edge locations',
                'Availability Zones',
                'AWS Regions',
                'Local Zones',
            ],
            'correct_answer' => 'Edge locations',
            'explanation' => 'Amazon CloudFront caches content at AWS Edge Locations to deliver it quickly to users with low latency.',
            'sort_order' => 424,
        ]);
        $set->questions()->create([
            'question' => "Question 425\n\nWhich AWS offering can be natively associated with AWS WAF?",
            'options' => [
                'Application Load Balancer',
                'Network Load Balancer',
                'Gateway Load Balancer',
                'AWS Lambda',
            ],
            'correct_answer' => 'Application Load Balancer',
            'explanation' => 'AWS WAF can be directly associated with an Application Load Balancer (ALB) to protect web applications from common web attacks.',
            'sort_order' => 425,
        ]);
        $set->questions()->create([
            'question' => "Question 426\n\nA company needs to apply security rules to specific Amazon EC2 instances.\n\nWhich AWS service or feature provides this functionality?",
            'options' => [
                'AWS WAF',
                'Network ACLs',
                'Amazon VPC',
                'Security groups',
            ],
            'correct_answer' => 'Security groups',
            'explanation' => 'Security groups act as virtual firewalls for EC2 instances, controlling inbound and outbound traffic for specific instances.',
            'sort_order' => 426,
        ]);
        $set->questions()->create([
            'question' => "Question 427\n\nWhich AWS service supports MySQL database engines?",
            'options' => [
                'Amazon DynamoDB',
                'Amazon RDS',
                'Amazon DocumentDB (with MongoDB compatibility)',
                'Amazon ElastiCache',
            ],
            'correct_answer' => 'Amazon RDS',
            'explanation' => 'Amazon RDS supports MySQL and other relational database engines as a fully managed database service.',
            'sort_order' => 427,
        ]);
        $set->questions()->create([
            'question' => "Question 428\n\nA company is planning to migrate applications to the AWS Cloud. During a system audit, the company finds that its content management system (CMS) application is incompatible with cloud environments.\n\nWhich migration strategies will help the company to migrate the CMS application with the LEAST effort? (Choose two.)",
            'options' => [
                'Retire',
                'Rehost',
                'Repurchase',
                'Replatform',
                'Refactor',
            ],
            'correct_answer' => json_encode([
                'Rehost',
                'Repurchase',
            ]),
            'explanation' => 'Rehost (lift and shift) and Repurchase (replace with a SaaS solution) require the least migration effort for an incompatible CMS application.',
            'sort_order' => 428,
        ]);
        $set->questions()->create([
            'question' => "Question 429\n\nA company needs to mount a file share across multiple Amazon EC2 instances as a mapped drive by using the SMB protocol.\n\nWhich AWS service will meet these requirements?",
            'options' => [
                'Amazon FSx for Windows File Server',
                'Amazon Elastic File System (Amazon EFS)',
                'Amazon S3',
                'AWS DataSync',
            ],
            'correct_answer' => 'Amazon FSx for Windows File Server',
            'explanation' => 'Amazon FSx for Windows File Server provides a fully managed Windows file system that supports the SMB protocol for shared file access across EC2 instances.',
            'sort_order' => 429,
        ]);
        $set->questions()->create([
            'question' => "Question 430\n\nWhich option is an advantage of AWS Cloud computing that minimizes variable costs?",
            'options' => [
                'High availability',
                'Economies of scale',
                'Global reach',
                'Agility',
            ],
            'correct_answer' => 'Economies of scale',
            'explanation' => 'AWS achieves economies of scale, helping reduce variable costs by sharing infrastructure across many customers.',
            'sort_order' => 430,
        ]);
    }

}
