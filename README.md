# PKI-BASED-SECURE-DOCUMENT-STORAGE-AND-TRANSMISSION-SYSTEM

PROJECT TOPOLOGY

![image](https://github.com/roopdubey786/PKI-BASED-SECURE-DOCUMENT-STORAGE-AND-TRANSMISSION-SYSTEM/assets/62478363/90a2cbf3-58e4-455b-ba52-0146946e8bca)
 
The Windows 10 virtual machine that houses the PKI Server: Stores, issues, and authenticates digital certificates by employing a certificate authority (CA).
•	Cancels certifications as needed.
•	Disseminates lists of certificate revocation (CRLs). Project Team 1 of 6
•	Conserves the private key required for certificate signing.
•	The CentOS virtual machine hosting the Bank Web Server:
•	Uses HTTPS protocol to implement secure client-server communication.
•	Offers a web page that clients can access via the web server; Employs a hardware security module (HSM) to protect cryptographic activities and the public and private key pairs related to the web server.
•	The Windows host machine, known as the "client machine," is set up as follows:
•	For secure connection between the client and server, the web browser is set up using the bank's web server's CA certificate chain.
•	The public and private key pairs required for signing payroll deposit files are securely signed and protected using a smart card.


Commands to Create the Bank CA Root Certificate:
•	Generating Private Key on PKI server: 
genpkey -outform pem -algorithm rsa -pkeyopt rsa_keygen_bits:2048 -aes-128-cbc -pass pass:CyB@ter123 -out CArootkey.key
•	Generating root certificate on PKI server:
req -new -x509 -outform pem -sha256 -set_serial 0x100 -key CArootkey.key -days 365 -out PKIcert.cer

Commands to Create Bank Web Server Certificate:

•	Generating Private Key on bank server:
genpkey -outform pem -algorithm rsa -pkeyopt rsa_keygen_bits:2048 -aes-128-cbc -pass pass:CyB@ter123 -out Web-dube0211.key 
•	Generating csr on bank server:
req -new -outform pem -key Web-dube0211-Priv.key -out Web-projectteam2.csr
•	Generating cer by signing the bank server’s .csr with root certificate on PKI:
x509 -req -in Web-dube0211.csr -CA CArootkyeycer -set_serial 0x300 -sha256 -CAkey CArootkey.key -days 365 -extfile WebSrv.txt -out Web-dube0211.cer

URL Security and Certificate Details on Browser

![image](https://github.com/roopdubey786/PKI-BASED-SECURE-DOCUMENT-STORAGE-AND-TRANSMISSION-SYSTEM/assets/62478363/b4dfa4b4-31db-462e-bf59-cfcc38b7a47e)

![image](https://github.com/roopdubey786/PKI-BASED-SECURE-DOCUMENT-STORAGE-AND-TRANSMISSION-SYSTEM/assets/62478363/0172b822-30e0-421e-b2d2-1ae1fd5b527f)

TEST CASES
Test Case 1 User 1: 

Document signed with valid certificate Issued by Bank PKI
•	Signature valid
•	Certificate Valid

![image](https://github.com/roopdubey786/PKI-BASED-SECURE-DOCUMENT-STORAGE-AND-TRANSMISSION-SYSTEM/assets/62478363/79ca80d6-40da-42d0-a083-84bf53aedfb3)

![image](https://github.com/roopdubey786/PKI-BASED-SECURE-DOCUMENT-STORAGE-AND-TRANSMISSION-SYSTEM/assets/62478363/71add843-3ac7-4157-8214-dcd49926fa56)

Test Case 2 User 2

Document signed with revoked certificate Issued by Bank PKI
•	Signature valid
•	Certificate revoked

![image](https://github.com/roopdubey786/PKI-BASED-SECURE-DOCUMENT-STORAGE-AND-TRANSMISSION-SYSTEM/assets/62478363/b07937f6-2817-41be-99a7-182f33f29a0f)

![image](https://github.com/roopdubey786/PKI-BASED-SECURE-DOCUMENT-STORAGE-AND-TRANSMISSION-SYSTEM/assets/62478363/f5aed9ac-f5b6-4bfd-aa9d-61abe8c764e4)

Test Case 3 User 3

Document signed with expired certificate Issued by Bank PKI
•	Signature valid
•	Certificate expired

![image](https://github.com/roopdubey786/PKI-BASED-SECURE-DOCUMENT-STORAGE-AND-TRANSMISSION-SYSTEM/assets/62478363/099fa6c6-a5ec-4afa-a2e1-80e5464de905)

![image](https://github.com/roopdubey786/PKI-BASED-SECURE-DOCUMENT-STORAGE-AND-TRANSMISSION-SYSTEM/assets/62478363/9b29bd7f-c38c-4e34-925d-cad8e10a6e3d)

Test Case 4 User 4

Document signature tampered 
•	Signature Fails

![image](https://github.com/roopdubey786/PKI-BASED-SECURE-DOCUMENT-STORAGE-AND-TRANSMISSION-SYSTEM/assets/62478363/3104e650-30db-4dff-ba20-44645f9fcd1b)

![image](https://github.com/roopdubey786/PKI-BASED-SECURE-DOCUMENT-STORAGE-AND-TRANSMISSION-SYSTEM/assets/62478363/41080afa-c79d-4a80-811f-e2d7830987dc)

Test Case 5 User 5

Document signed with certificate issued from non-bank trusted issuer 
•	Signature valid 
•	Certificate not from trusted source

![image](https://github.com/roopdubey786/PKI-BASED-SECURE-DOCUMENT-STORAGE-AND-TRANSMISSION-SYSTEM/assets/62478363/addc6528-0d5c-4c83-bb68-c07937b4f91c)

![image](https://github.com/roopdubey786/PKI-BASED-SECURE-DOCUMENT-STORAGE-AND-TRANSMISSION-SYSTEM/assets/62478363/87b77baa-79af-4eb5-804c-47f22bdfe66f)



