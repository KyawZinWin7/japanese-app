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
                'question_count' => 110,
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
    }

}
























