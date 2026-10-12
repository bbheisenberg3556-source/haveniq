import React, { useState, useEffect } from 'react';
import { Head } from '@inertiajs/react';
import axios from 'axios';

export default function Results({ sessionId }) {
    const [status, setStatus] = useState('generating');
    const [roomData, setRoomData] = useState(null);
    const [error, setError] = useState(null);
    const [isLightboxOpen, setIsLightboxOpen] = useState(false);

    useEffect(() => {
        let pollInterval;
        let attempts = 0;

        const checkStatus = async () => {
            attempts++;
            try {
                const { data } = await axios.get(`/api/v1/rooms/${sessionId}/status`);
                
                if (data.status === 'failed') {
                    setStatus('failed');
                    clearInterval(pollInterval);
                    return;
                }

                if (data.status === 'completed' && data.has_personality_profile) {
                    clearInterval(pollInterval);
                    fetchFullData();
                } else if (data.status === 'completed' && attempts >= 10) {
                    // Failsafe: if completed but profile took longer, retrieve whatever is ready
                    clearInterval(pollInterval);
                    fetchFullData();
                } else {
                    setStatus(data.status);
                }
            } catch (err) {
                console.error('Error fetching room status:', err);
                if (attempts >= 35) {
                    setError('Connection lost while checking room status. Please refresh.');
                    clearInterval(pollInterval);
                }
            }
        };

        const fetchFullData = async () => {
            try {
                const { data } = await axios.get(`/api/v1/rooms/${sessionId}`);
                setRoomData(data);
                setStatus('completed');
            } catch (err) {
                console.error('Error fetching room data:', err);
                setError('Failed to load room details. Please try refreshing.');
            }
        };

        // Poll every 2.5 seconds
        pollInterval = setInterval(checkStatus, 2500);
        checkStatus();

        return () => clearInterval(pollInterval);
    }, [sessionId]);

    if (error || status === 'failed') {
        return (
            <div className="container" style={{ textAlign: 'center', paddingTop: '10vh' }}>
                <Head title="Error | HavenIQ" />
                <h1 className="title" style={{ color: 'var(--error-color)' }}>Generation Failed</h1>
                <p className="subtitle">{error || 'We encountered an unexpected issue while generating your room. Please try again.'}</p>
                <button className="btn btn-primary" onClick={() => window.location.href = '/'} style={{ marginTop: '2rem' }}>
                    Start Over
                </button>
            </div>
        );
    }

    if (status !== 'completed' || !roomData) {
        return (
            <div className="container" style={{ textAlign: 'center', paddingTop: '10vh' }}>
                <Head title="Generating... | HavenIQ" />
                <div className="loader"></div>
                <h2 className="title" style={{ fontSize: '2rem', marginTop: '2rem' }}>
                    Visualizing Your Space
                </h2>
                <p className="subtitle">
                    Our AI is generating an architectural render and analyzing your cognitive orientation...
                </p>
                <div className="progress-container" style={{ maxWidth: '400px', margin: '2rem auto' }}>
                    <div className="progress-fill loader-bar"></div>
                </div>
            </div>
        );
    }

    const { image_url, personality_profile } = roomData;
    const cleanImageUrl = image_url ? image_url.replace(/^http:\/\/localhost(?::\d+)?\/storage/, '/storage') : '/presets/warm_modern.jpg';

    const handleDownload = () => {
        const link = document.createElement('a');
        link.href = cleanImageUrl;
        link.download = `haveniq-${sessionId}.webp`;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    };

    return (
        <div className="results-container">
            <Head title="Your Haven Results | HavenIQ" />
            
            <header className="header" style={{ marginBottom: '2.5rem' }}>
                <h1 className="title">Your Haven</h1>
                <p className="subtitle">A visual and psychological reflection of your personal aesthetic.</p>
            </header>

            {/* Featured Hero Architectural Showcase */}
            <div className="hero-showcase">
                <div className="image-badge">
                    <span>✨</span> FLUX 2 Pro Architectural Visualization
                </div>
                
                <div className="hero-image-wrapper">
                    <img 
                        src={cleanImageUrl} 
                        alt="Generated Architectural Space" 
                        className="hero-image"
                        onClick={() => setIsLightboxOpen(true)}
                        onError={(e) => {
                            e.target.onerror = null;
                            e.target.src = '/presets/warm_modern.jpg';
                        }} 
                    />
                </div>

                <div className="image-actions">
                    <button className="action-pill" onClick={() => setIsLightboxOpen(true)} title="Expand Fullscreen">
                        🔍 View Fullscreen
                    </button>
                    <button className="action-pill" onClick={handleDownload} title="Download Render">
                        📥 Download Render
                    </button>
                </div>
            </div>

            {/* Psychological Architecture Section */}
            <section className="personality-section">
                <div className="section-header">
                    <h2 className="section-title">Personality & Character Profile</h2>
                    <p className="section-subtitle">Defining your personality and primary character traits through your living space.</p>
                </div>
                
                {personality_profile?.traits && personality_profile.traits.length > 0 ? (
                    <div className="traits-grid">
                        {personality_profile.traits.map((trait, index) => (
                            <div key={index} className="trait-card">
                                <div className="trait-header">
                                    <h3 className="trait-name">{trait.name}</h3>
                                    <span className="trait-score">{trait.score}% Prominence</span>
                                </div>
                                {trait.anchor && (
                                    <span className="trait-anchor-tag">
                                        ✦ Feature: {trait.anchor}
                                    </span>
                                )}
                                <p className="trait-explanation">{trait.explanation}</p>
                            </div>
                        ))}
                    </div>
                ) : (
                    <div className="glass-card" style={{ padding: '2rem', textAlign: 'center', color: 'var(--text-secondary)', marginBottom: '2rem' }}>
                        <p>Personality profile is being finalized...</p>
                    </div>
                )}

                {personality_profile?.summary && (
                    <div className="summary-card">
                        <h3 className="summary-title">
                            <span>✦</span> Personality & Character Summary
                        </h3>
                        <div className="summary-body" style={{ whiteSpace: 'pre-line' }}>{personality_profile.summary}</div>
                    </div>
                )}
            </section>

            {/* Action Bar */}
            <div style={{ display: 'flex', justifyContent: 'center', gap: '1rem', marginTop: '3.5rem', flexWrap: 'wrap' }}>
                <button className="btn btn-primary" onClick={() => window.location.href = '/'}>
                    Design Another Space
                </button>
                <button className="btn btn-secondary" onClick={handleDownload}>
                    Download Architectural Render
                </button>
            </div>

            {/* Lightbox Modal */}
            {isLightboxOpen && (
                <div className="lightbox-overlay" onClick={() => setIsLightboxOpen(false)}>
                    <div className="lightbox-content" onClick={(e) => e.stopPropagation()}>
                        <button className="lightbox-close" onClick={() => setIsLightboxOpen(false)} title="Close">
                            ✕
                        </button>
                        <img src={cleanImageUrl} alt="Full resolution render" className="lightbox-image" />
                    </div>
                </div>
            )}
        </div>
    );
}
